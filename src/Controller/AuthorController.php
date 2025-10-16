<?php

namespace App\Controller;
use App\Repository\AuthorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;
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

    #[Route('/ShowAll', name: 'ShowAll')]
    public function ShowAll(AuthorRepository $repo): Response{
        $Author=$repo->findAll();
        return $this->render('author/ShowAll.html.twig',['list'=>$Author]);
    }

    #[Route('/add', name: 'add')]
    public function add (ManagerRegistry $doctrime): Response{
        $Author=new authors();
        $authors->setEmail(email:'foulen@esprit.tn');
        $authors->setUsername(username:'foulen');
        $em=$doctrime->getManager();
        $em->persist($authors);
        $em->flush();
        //return new Response(content:"Aurhors added sucessfully");
        //return $this->render('author/add.html.twig',['list'=>$authors]);
        return $this->redirectToRoute( 'ShowAll');
    }


    #[Route('/addForm',name:'addForm')]
    public function addForm(Request $request, ManagerRegistry $doctrine){
    $author=new Author();
    $form=$this->createForm(AuthorType::class,$author);
    $form->add('Add',SubmitType::class);
 
    $form->handleRequest($request);
    if($form->isSubmitted()){
     $em=$doctrine->getManager();
     $em->persist($author);
     $em->flush();
     return $this->redirectToRoute('showAll');
    }
    return $this->render('author/add.html.twig',['formulaire'=>$form->createView()]);
    // return $this->renderForm()
    }


    #[Route('/delectAuthors/{id}', name: 'delectAuthors')]
    public function delectAuthors($id,AuthorRepository $repo,ManagerRegistry $doctrime): Response{
        //cherche un auteur selon son id
        ///find,findall
        $Author=$repo->find(id:$id);
        ///procéder à la suppression
        $em=$doctrime->getManager();
        $em->remove( $Author);
        $em->flush();
        return $this->redirectToRoute( 'ShowAll');
        }


    #[Route('/show/{id}',name:'show')]
    public function showDetails ($id, AuthorRepository $repo): Response{
        $author=$repo->find(id: $id);
        return $this->render( 'author/ShowDetails.html.twig', ['author'=>$Author]);
    }
}
