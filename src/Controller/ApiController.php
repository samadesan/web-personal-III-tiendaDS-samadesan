<?php

namespace App\Controller;
use App\Service\ProductsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/api')]
class ApiController extends AbstractController
{
    #[Route('/show/{id}', name: 'api-show', methods: ['GET'])]
    public function show(ProductsService $productsService, int $id): JsonResponse
    {
        // Usamos el servicio en lugar de ManagerRegistry directamente
        $product = $productsService->getProductById($id);

        if (!$product) {
            return new JsonResponse(["error" => "Producto no encontrado"], Response::HTTP_NOT_FOUND);
        }

        $data = [
            "id"    => $product->getId(),
            "name"  => $product->getName(),
            "price" => $product->getPrice(),
            "photo" => $product->getPhoto()
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }
}