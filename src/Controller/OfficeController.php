<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class OfficeController extends AbstractController
{
    #[Route('/office', name: 'app_office')]
    public function index(): Response
    {
        return $this->render('office/index.html.twig', [
            'controller_name' => 'OfficeController',
        ]);
    }
}
