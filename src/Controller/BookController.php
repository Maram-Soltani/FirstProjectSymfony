<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\BookRepository;
use App\Repository\AuthorRepository;
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
            $book->setRef('BK-' . strtoupper(uniqid()));
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
public function listBooks(BookRepository $bookRepository, Request $request): Response
{
    // 1️ Récupérer la valeur saisie dans le champ de recherche
    $ref = $request->query->get('ref');

    // 2️ Si l’utilisateur cherche une ref, on filtre
    if ($ref) {
        $books = $bookRepository->searchBookByRef($ref);
    } else {
        $books = $bookRepository->findAll();
    }

    // 3️ Compter les livres publiés et non publiés
    $countPublished = 0;
    $countUnpublished = 0;

    foreach ($books as $book) {
        if ($book->getPublished()) {
            $countPublished++;
        } else {
            $countUnpublished++;
        }
    }

    // 4️ Renvoyer le tout au template
    return $this->render('book/liste.html.twig', [
        'books' => $books,
        'countPublished' => $countPublished,
        'countUnpublished' => $countUnpublished,
        'ref' => $ref, // utile pour réafficher la valeur dans le champ
    ]);
}


    #[Route('/book/edit/{id}', name: 'book_edit')]
public function edit(int $id, Request $request, ManagerRegistry $doctrine, BookRepository $bookRepository): Response
{
    $book = $bookRepository->find($id);

    if (!$book) {
        throw $this->createNotFoundException('Livre non trouvé.');
    }

    $form = $this->createForm(BookType::class, $book);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em = $doctrine->getManager();
        $em->flush();

        $this->addFlash('success', 'Livre modifié avec succès !');
        return $this->redirectToRoute('liste_books');
    }

    return $this->render('book/edit.html.twig', [
        'form' => $form->createView(),
        'book' => $book,
    ]);
}
#[Route('/showbook/{id}', name: 'showbook')]
    public function showbook(BookRepository $repo, $id)
    {
        $book = $repo->find($id);

        if (!$book) {
            throw $this->createNotFoundException('Livre non trouvé');
        }

        $author = $book->getAuthor(); // récupérer l'auteur associé

        return $this->render('book/showbook.html.twig', [
            'book' => $book,
            'author' => $author,
        ]);
    }
#[Route('/deletebook/{id}', name:'deletebook')]
public function deletebook($id, BookRepository $repo, ManagerRegistry $doctrine): Response
{
    $book = $repo->find($id);
    if (!$book) {
        throw $this->createNotFoundException('Livre non trouvé');
    }

    $em = $doctrine->getManager();
    $em->remove($book);
    $em->flush();

    return $this->redirectToRoute('liste_books'); // ou ta route liste
}

///
public function searchBookByRef($ref)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.ref LIKE :ref')
            ->setParameter('ref', '%'.$ref.'%')
            ->getQuery()
            ->getResult();
    }

}
