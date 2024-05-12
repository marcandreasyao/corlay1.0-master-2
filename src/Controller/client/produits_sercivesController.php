<?php

namespace App\Controller\client;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class produits_sercivesController extends AbstractController
{
    #[Route('/produits-services', name: 'app_produits_sercives')]
    public function index(): Response
    {
        return $this->render('client/produits_services.html.twig', [
            'controller_name' => 'produits_sercivesController',
        ]);
    }
}
