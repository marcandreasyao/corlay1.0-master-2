<?php

namespace App\Controller\manager;

use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ArticlesRepository;
use App\Repository\BoutiqueRepository;
use App\Repository\LubrifiantsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\AlbumsRepository;

/**
 * @Route("/manager", name="")
 */
class ManagerController extends AbstractController
{


    private $miniaturedir ='client/img/blog/thumb/minified/';
    private $image_article = 'client/img/blog/';

    public ArticlesRepository $articlesRepo;
    public LubrifiantsRepository $lubrifiantsRepo;
    public BoutiqueRepository $boutiqueRepo;
    public AlbumsRepository  $albumsRepo;

    public function __construct(ArticlesRepository $articlesRepo, LubrifiantsRepository $lubrifiantsRepo,
                                BoutiqueRepository $boutiqueRepo, AlbumsRepository $albumsRepo)
    {
        $this->boutiqueRepo = $boutiqueRepo;
        $this->articlesRepo = $articlesRepo;
        $this->lubrifiantsRepo = $lubrifiantsRepo;
        $this->albumsRepo = $albumsRepo;
    }

    /**
     * @Route("/accueil", name="app_manager")
     */
    public function index(): Response
    {
        $albumsnumber = $this->albumsRepo->compteuralbums();
        $articlesnumber = $this->articlesRepo->compteurarticles();
        $boutiquesnumber = $this->boutiqueRepo->compteurboutiques();
        $lubrifiantsnumber = $this->lubrifiantsRepo->compteurlubrifiants();
        $recentsposts = $this->articlesRepo->homeposts(6);
        $deuxboutiques = $this->boutiqueRepo->limitedshops(2);
        return $this->render('manager/index.html.twig', [
            'controller_name' => 'ManagerController',
            'counter_article' => $articlesnumber,
            'counter_boutique' => $boutiquesnumber,
            'counter_lubrifiants' => $lubrifiantsnumber,
            'recents' => $recentsposts,
            'thumb_dir' => $this->miniaturedir,
            'two_shops' => $deuxboutiques,
            'image' => $this->image_article,
            'counter_albums' => $albumsnumber
        ]);
    }

}
