<?php

namespace App\Controller;
use App\Service\MessageGenerator;
use App\Service\HappyQuote;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        
        return $this->render('home/index.html.twig');
    }

    #[Route('/h', name: 'home')]
        public function home(MessageGenerator $messageGenerator): Response{
                $message = $messageGenerator->getHappyMessage();
                return new Response("<h1>Citation du jour :</h1><p>$message</p>");
}

#
}
