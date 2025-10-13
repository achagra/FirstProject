<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\FormNameType;
use App\Repository\AuthorRepository;
use Doctrine\Persistence\ManagerRegistry ;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\MakerBundle\Security\Model\AuthenticatorType;
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

   

    #[Route('/Afficher', name: 'affichage')]
    public function affichage( ) : Response{
       return new Response('hello');
    }

     #[Route('/afficherTableau', name: 'afficherTab')]
public function AfficherTab()
{
    $authors = array(
        array(
            'id' => 1,
            'picture' => '/assets/images/felfel1.png',
            'username' => 'Victor Hugo',
            'email' => 'victor.hugo@gmail.com',
            'nb_books' => 100
        ),
        array(
            'id' => 2,
            'picture' => '/assets/images/felfel2.png',
            'username' => 'William Shakespeare',
            'email' => 'william.shakespeare@gmail.com',
            'nb_books' => 200
        ),
        array(
            'id' => 3,
            'picture' => '/assets/images/felfel3.png',
            'username' => 'Taha Hussein',
            'email' => 'taha.hussein@gmail.com',
            'nb_books' => 300
        ),
    );

    // On rend la vue Twig et on lui passe la variable
    return $this->render('author/list.html.twig', ['authors' => $authors]);
}

#[Route('/author/{id}', name: 'author_details')]
public function authorDetails($id)
{
    $authors = array(
        array(
            'id' => 1,
            'picture' => '/assets/images/felfel1.png',
            'username' => 'Victor Hugo',
            'email' => 'victor.hugo@gmail.com',
            'nb_books' => 100
        ),
        array(
            'id' => 2,
            'picture' => '/assets/images/felfel2.png',
            'username' => 'William Shakespeare',
            'email' => 'william.shakespeare@gmail.com',
            'nb_books' => 200
        ),
        array(
            'id' => 3,
            'picture' => '/assets/images/felfel3.png',
            'username' => 'Taha Hussein',
            'email' => 'taha.hussein@gmail.com',
            'nb_books' => 300
        ),
    );

    // Rechercher l’auteur par son id
    $author = null;
    foreach ($authors as $a) {
        if ($a['id'] == $id) {
            $author = $a;
            break;
        }
    }

    if (!$author) {
        throw $this->createNotFoundException("Auteur introuvable !");
    }

    return $this->render('author/showAuthor.html.twig', ['author' => $author]);
  }
    #[Route(path :'/ShowAllAuthor', name:'ShowAllAuthor')]
    public function ShowAllAuthor(AuthorRepository $repo):Response{
        $author=$repo->findAll();
        return $this->render('author/listAuthor.html.twig' , ['list' => $author]);

    }     
    
    #[Route ('/add' , name:'add')]
    public function Add( ManagerRegistry $doctrine  ){
        $author=new Author() ;
        $author->setUsername('Test');
        $author->setEmail('test@gmail.com');
        $author->setAge(25);
        $em=$doctrine->getManager();
        $em->persist($author);
        $em->flush();
        return new Response('Author add successfully');                                  

        

    
    }

    #[Route('/addForm','addForm')]

    public function addForm( ManagerRegistry $doctrine , Request $request ){
        $author=new Author();
        $form=$this->createForm(FormNameType::class , $author);
        $form->add('add', SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em=$doctrine->getManager();
            $em->persist($author);
            $em->flush();
            return new Response('Author added successfuly');
        }
        return $this->render('author/add.html.twig', ['formulaire'=>$form->createView()]);
        
      }

      
      #[Route("/author/{id}/edit", "author_edit")]
     
    public function editForm(Request $request, ManagerRegistry $doctrine , Author $author): Response
    {
        $form = $this->createForm(FormNameType::class, $author);
        $form->handleRequest($request);
        

        if ($form->isSubmitted() && $form->isValid()) {
            $em =$doctrine->getManager();
            $em -> flush();


            return $this->redirectToRoute('ShowAllAuthor');
        }

        return $this->render('author/edit.html.twig', [
            'formulaire' => $form->createView(),
            'author' => $author,
        ]);
    }

    #[Route('/delete/{id}', name:'delete')]

    public function Delete (Request $request , ManagerRegistry $doctrine ,$id,AuthorRepository $repo ){
        //chercher un auteur selon son ID
        $author=$repo->find($id);
        $em=$doctrine->getManager();
        $em->remove($author);
        $em->flush();
        return $this->redirect('ShowAllAuthor');

    }

    #[Route('/showDetailsAuthor/{id}',name:'showDetailsAuthor')]

    public function showDetailsAuthor(AuthorRepository $repo, $id){
        $author=$repo->find($id);
        return $this->render('author/ShowDetailsAuthor.html.twig', ['author'=> $author]);

    }




    



   


}
    



