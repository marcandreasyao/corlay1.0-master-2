<?php

namespace App\Controller\client;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index()
    {
        return $this->render('client/contact.html.twig', [
            'controller_name' => 'ContactController',
        ]);
    }
}
