<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ServiceController extends AbstractController
{
    #[Route('/service', name: 'app_service')]
    public function index(): Response
    {
        return $this->render('service/index.html.twig', [
            'controller_name' => 'ServiceController',
        ]);
    }

    #[Route('/service/show/{name}', name: 'show_service')]
    public function showService(string $name): Response
    {
    return $this->render('service/show.html.twig', [
        'name' => $name,
    ]);
}


    #[Route('/go-to-index', name: 'go_to_index')]
public function goToIndex(): Response
{
    // Redirection vers la route 'app_home' définie dans HomeController::index()
    return $this->redirectToRoute('app_home');
}

}
