<?php

namespace App\Controller\client;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PartnersRepository;

class MainController extends AbstractController
{

    protected PartnersRepository $partnersRepo;
    protected $partners_dir ='client/images/partners/';

    public function __construct(PartnersRepository $partnersRepo)
    {
        $this->partnersRepo = $partnersRepo;
    }

    #[Route('/', name: 'app_main')]
    public function index(): Response
    {
        return $this->render('client/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    #[Route('/politiquequalite', name: 'app_politiquequalite')]
    public function politique(): Response
    {
        return $this->render('client/politiquequalite.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    #[Route('/aproposdecorlay', name: 'app_about')]
    public function about(): Response
    {
        $partners = $this->partnersRepo->findAll();
        return $this->render('client/about.html.twig', [
            'partners' => $partners,
            'partners_dir' => $this->partners_dir
        ]);
    }
}
