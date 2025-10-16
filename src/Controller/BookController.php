<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Book;
use App\Form\BookType;
use Doctrine\Persistence\ManagerRegistry;

final class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    //add
    #[Route('/book/add', name: 'book_add')]
public function add(Request $request, ManagerRegistry $doctrine): Response
{
    $book = new Book();
    $book->setPublished(true); // publié par défaut
    $book->setPublicationDate(new \DateTime()); // date actuelle

    // Création du formulaire
    $form = $this->createForm(BookType::class, $book);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Incrémentation nb_books de l'auteur
        $author = $book->getAuthor();
        $author->setNbBooks($author->getNbBooks() + 1);

        $em = $doctrine->getManager();
        $em->persist($book);
        $em->flush();

        $this->addFlash('success', 'Book ajouté avec succès !');

        // Redirection vers la liste des livres
        return $this->redirectToRoute('add');
    }

    return $this->render('book/add.html.twig', [
        'form' => $form->createView(),
    ]);
}

}
