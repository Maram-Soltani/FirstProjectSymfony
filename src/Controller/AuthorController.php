<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AuthorController extends AbstractController
{
    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }

    #[Route('/ShowAll',name:'showAll')]
    public function showAll(AuthorRepository $repo){
     $authors=$repo->findAll();
     return $this->render('author/showAll.html.twig',['list'=>$authors]);
    }

    #[Route('/add', name:'add')]
    public function add(ManagerRegistry $doctrine){
      $author=new Author();
      $author->setEmail('foulen@esprit.tn');
      $author->setUsername('foulen');
      $author->setNbBooks(0);
      $em=$doctrine->getManager();
      $em->persist($author);
      $em->flush();
      //return new Response("Author added suceesfully");
      return $this->redirectToRoute('showAll');
    }


    #[Route('/addForm',name:'addForm')]
    public function addForm(Request $request, ManagerRegistry $doctrine){
    $author=new Author();
    $form=$this->createForm(AuthorType::class,$author);
    //$form->add('Add',SubmitType::class);

    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $author->setNbBooks(0); // valeur par défaut
        $em = $doctrine->getManager();
        $em->persist($author);
        $em->flush();
        return $this->redirectToRoute('showAll');
    }
    return $this->render('author/add.html.twig',['formulaire'=>$form->createView()]);
    // return $this->renderForm()
    }

    #[Route('/deleteAuthor/{id}',name:'deleteAuthor')]
    public function deleteAuthor($id,AuthorRepository $repo, ManagerRegistry $doctrine){
     // chercher un auteur selon son id
     //find , findAll , findOneby 
     $author=$repo->find($id);
     //procéder à la suppression 
      $em=$doctrine->getManager();
      $em->remove($author);
      $em->flush();// l'ajout , la suppression et la modification
      return $this->redirectToRoute('showAll');
    }


   #[Route('/showDetails/{id}',name:'showDetails')]
    public function showDetails($id,AuthorRepository $repo){
       $author=$repo->find($id);
       return $this->render('author/showDetails.html.twig',['author'=>$author]);
    }

    #[Route('/updateAuthor/{id}', name:'updateAuthor')]
public function updateAuthor($id, AuthorRepository $repo, Request $request, ManagerRegistry $doctrine): Response
{
    $author = $repo->find($id);
    if (!$author) {
        throw $this->createNotFoundException('Auteur non trouvé');
    }

    $form = $this->createForm(AuthorType::class, $author);
    $form->add('Update', SubmitType::class);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em = $doctrine->getManager();
        $em->flush();
        return $this->redirectToRoute('showAll');
    }

    return $this->render('author/edit.html.twig', [
        'formulaire' => $form->createView()
    ]);
}
    /*#[Route('/ShowAllAuthorsQB',name:'ShowAllAuthorsQB')]
    public function ShowAllAuthorsQB(AuthorRepository $repo){
       $author=$repo->ShowAllAuthorsQB();
       return $this->render('author/showAll.html.twig',['list'=>$author]);
    }*/

       #[Route('/ShowAllAuthorsQB', name: 'ShowAllAuthorsQB')]
public function ShowAllAuthorsQB(AuthorRepository $repo): Response
{
    $authors = $repo->ShowAllAuthorsQB(); // ta méthode du repository
    return $this->render('author/showAll.html.twig', [
        'list' => $authors,
    ]);
}
}
