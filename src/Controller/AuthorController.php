<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    #[Route('/authorName/{name}', name: 'showAuthor')]
    public function showAuthor( $name) : Response{
       return $this->render('author/list.html.twig',['nom'=>$name]);
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


    



   


}
    



