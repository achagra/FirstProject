<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    #[Route('/addBook','addBook')]

    public function addBook(  ManagerRegistry $doctrine  , Request $request ) : Response {
        $book=new Book();
        $form=$this->createForm(BookType::class , $book);
        $form->add('add', SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $author = $book->getAuthor();
            $author->setNbBooks($author->getNbBooks() + 1);
            $em=$doctrine->getManager();
            $em->persist($book);
            $em->flush();
            return new Response('Book added successfuly');
        }
        return $this->render('book/add.html.twig' , ['formulaire' => $form]);
    }
    #[Route(path :'/book/published', name:'book_published')]
    public function ShowAllAuthor(BookRepository $repo):Response{
        $book=$repo->findBy(['published' => true]);
        $publishedCount = $repo->count(['published' => true]);
        $nonPublishedCount = $repo->count(['published' => false]);

        return $this->render('book/listbook.html.twig' , [
            'list' => $book , 
            'published_count' => $publishedCount,
            'non_published_count' => $nonPublishedCount,]);
    }

    #[Route("/book/{id}/edit", "book_edit")]
     
    public function editForm(Request $request, ManagerRegistry $doctrine , Book $book): Response
    {
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);
        

        if ($form->isSubmitted() && $form->isValid()) {
            $em =$doctrine->getManager();
            $em -> flush();


            return $this->redirectToRoute('book_published');
        }

        return $this->render('book/edit.html.twig', [
            'formulaire' => $form->createView(),
            'list' => $book,
        ]);
    }

    #[Route('/delete/{id}', name:'delete')]

    public function Delete (Request $request , ManagerRegistry $doctrine ,$id,BookRepository $repo ): Response {
        //chercher un auteur selon son ID
        $book=$repo->find($id);
        $em=$doctrine->getManager();
        $em->remove($book);
        $em->flush();
        return $this->redirect('book_published');
    }

    #[Route('/showDetailsBook/{id}',name:'showDetailsBook')]

    public function showDetailsAuthor(BookRepository $repo, $id){
        $book=$repo->find($id);
        return $this->render('book/ShowDetailsBook.html.twig', ['Book'=> $book]);

    }

}
