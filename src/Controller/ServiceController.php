<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

 class ServiceController extends AbstractController
{
    #[Route('/service/{name}', name: 'app_service')]
    public function showService(String $name ): Response
    {
        return new Response ("service: ".$name);
        
    }

    #[Route('/service-twig/{name}', name: 'app_show_service')]
    public function showServiceTwig(string $name): Response
    {
        return $this->render('service/showService.html.twig', [
            'name' => $name,
        ]);
    }
     #[Route('/go-to-index', name: 'app_go_to_index')]
    public function goToIndex(): Response
    {
        return $this->redirectToRoute('Home');
    }

    
}
