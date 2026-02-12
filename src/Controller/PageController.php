<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Team;
use App\Service\ProductsService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PageController extends AbstractController
{
    #[Route('/', name: 'indice')]
    public function indice(ProductsService $productsService, ManagerRegistry $doctrine): Response
    {
        $products = $productsService->getProducts();
        $repository = $doctrine->getRepository(Team::class);
        $team = $repository->findAll();
        return $this->render('page/index.html.twig', [
            'products' => $products,
            'team' => $team
        ]);
    }

    #[Route('/sobre-nosotros', name: 'about')]
    public function about(ManagerRegistry $doctrine): Response
    {
        // Obtenemos el repositorio de la entidad Team
        $repository = $doctrine->getRepository(Team::class);
        // Recuperamos todos los registros
        $team = $repository->findAll();

        // Pasamos la variable 'team' a la vista
        return $this->render('page/about.html.twig', [
            'team' => $team
        ]);
    }
    #[Route('/blog', name: 'blog')]
    public function blog(): Response
    {
        return $this->render('page/blog.html.twig');
    }

    #[Route('/blog/detalles', name: 'detalle')]
    public function detalle(): Response
    {
        return $this->render('page/detail.html.twig');
    }

    #[Route('/contacto', name: 'contacto')]
    public function contacto(): Response
    {
        return $this->render('page/contact.html.twig');
    }

    #[Route('/juegos', name: 'game-shop')]
    public function gameShop(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Product::class);
        $products = $repository->findAll();

        return $this->render('page/game-shop.html.twig', [
            'products' => $products
        ]);
    }

    #[Route('/plan-socios', name: 'plan-socios')]
    public function planSocios(): Response
    {
        return $this->render('page/plan-socios.html.twig');
    }

    #[Route('/reseñas', name: 'resenas')]
    public function resenas(): Response
    {
        return $this->render('page/resenas.html.twig');
    }

    #[Route('/servicio', name: 'servicio')]
    public function servicio(): Response
    {
        return $this->render('page/service.html.twig');
    }

    #[Route('/equipo', name: 'equipo')]
    public function equipo(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Team::class);
        $team = $repository->findAll();

        return $this->render('page/team.html.twig', [
            'team' => $team
        ]);
    }
}
