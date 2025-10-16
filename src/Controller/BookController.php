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
        $em = $doctrine->getManager();

        // Récupération de l'auteur sélectionné
        $author = $book->getAuthor();

        // Incrémentation nb_books
        $author->setNbBooks($author->getNbBooks() + 1);

        // Ajout du livre à la collection de l'auteur (relation bidirectionnelle)
        $author->addBook($book);

        // Persistance
        $em->persist($book);  // le $author sera mis à jour automatiquement
        $em->flush();

        $this->addFlash('success', 'Livre ajouté avec succès !');

        // Redirection vers la liste des livres (remplacez 'book_index' par votre route réelle)
        return $this->redirectToRoute('book_index');
    }
    
    return $this->render('book/add.html.twig', [
        'form' => $form->createView(),
    ]);
}

}
