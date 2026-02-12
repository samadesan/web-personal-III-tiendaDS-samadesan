<?php
namespace App\Controller;

use App\Entity\Product;
use App\Service\CartService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/cart')]
class CartController extends AbstractController {
    private $repository;
    private $cart;

    public function __construct(ManagerRegistry $doctrine, CartService $cart) {
        $this->repository = $doctrine->getRepository(Product::class);
        $this->cart = $cart;
    }
    #[Route('/', name: 'app_cart')]
    public function index(): Response {
        $products = $this->repository->getFromCart($this->cart);
        $items = [];
        $totalCart = 0;

        foreach($products as $product){
            $quantity = $this->cart->getCart()[$product->getId()];
            $item = [
                "id" => $product->getId(),
                "name" => $product->getName(),
                "price" => $product->getPrice(),
                "photo" => $product->getPhoto(),
                "quantity" => $quantity
            ];
            $totalCart += $item["quantity"] * $item["price"];
            $items[] = $item;
        }

        return $this->render('cart/index.html.twig', [
            'items' => $items,
            'totalCart' => $totalCart
        ]);
    }

    // Ruta: /cart/add/{id} (API para AJAX)
    #[Route('/add/{id}', name: 'cart_add', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function cart_add(int $id): Response {
        $product = $this->repository->find($id);
        if (!$product) {
            return new JsonResponse(["error" => "Product not found"], Response::HTTP_NOT_FOUND);
        }

        $this->cart->add($id, 1);

        $data = [
            "id" => $product->getId(),
            "name" => $product->getName(),
            "price" => $product->getPrice(),
            "photo" => $product->getPhoto(),
            "quantity" => $this->cart->getCart()[$product->getId()]
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route('/add-one/{id}', name: 'cart_add_one')]
    public function addOne(int $id): Response
    {
        $this->cart->add($id, 1);
        return $this->redirectToRoute('app_cart');
    }

    #[Route('/remove-one/{id}', name: 'cart_remove')]
    public function removeOne(int $id): Response
    {
        $this->cart->remove($id);
        return $this->redirectToRoute('app_cart');
    }

    #[Route('/delete/{id}', name: 'cart_delete')]
    public function delete(int $id): Response
    {
        $this->cart->delete($id);
        return $this->redirectToRoute('app_cart');
    }

    #[Route('/clear', name: 'cart_clear')]
    public function clear(): Response
    {
        $this->cart->clear();
        return $this->redirectToRoute('app_cart');
    }
}