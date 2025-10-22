<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\BookRepository;
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

    #[Route('/book/add', name: 'book_add')]
    public function add(Request $request, ManagerRegistry $doctrine): Response
    {
        $book = new Book();
        $book->setPublished(true);
        $book->setPublicationDate(new \DateTime());

        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $author = $book->getAuthor();

            $author->setNbBooks($author->getNbBooks() + 1);
            $author->addBook($book);

            $em->persist($book);
            $em->flush();

            $this->addFlash('success', 'Livre ajouté avec succès !');
            return $this->redirectToRoute('liste_books');
        }

        return $this->render('book/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/books', name: 'liste_books')]
    public function listBooks(BookRepository $bookRepository): Response
    {
        $books = $bookRepository->findAll();

        $countPublished = 0;
        $countUnpublished = 0;

        foreach ($books as $book) {
            if ($book->getPublished()) {
                $countPublished++;
            } else {
                $countUnpublished++;
            }
        }

        return $this->render('book/liste.html.twig', [
            'books' => $books,
            'countPublished' => $countPublished,
            'countUnpublished' => $countUnpublished,
        ]);
    }
}
