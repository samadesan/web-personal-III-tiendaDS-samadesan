<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PageController extends AbstractController
{
    #[Route('/', name: 'indice')]
    public function indice(): Response
    {
        return $this->render('page/index.html.twig');
    }

    #[Route('/sobre-nosotros', name: 'about')]
    public function about(): Response
    {
        return $this->render('page/about.html.twig');
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
    public function gameShop(): Response
    {
        return $this->render('page/game-shop.html.twig');
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
    public function equipo(): Response
    {
        return $this->render('page/team.html.twig');
    }
}
