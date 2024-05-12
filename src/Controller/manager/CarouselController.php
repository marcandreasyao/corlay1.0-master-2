<?php

namespace App\Controller\manager;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Carousel;
use App\Utils\Globals;
use App\Repository\CarouselRepository;


class CarouselController extends AbstractController
{
    private CarouselRepository $carouselRepo;
    private Globals $globals;
    private $carou_dir = 'client/img/slider/';

    public function __construct(CarouselRepository $carouselRepo, Globals $globals)
    {
        $this->carouselRepo = $carouselRepo;
        $this->globals = $globals;
    }

    /**
     * @Route("/manager/carousel/list", name="app_carousel")
     */
    public function getCarousels()
    {
        $carousels = $this->carouselRepo->findAll();
        return $this->render('manager/carousel.html.twig',[
            'carous' => $carousels,
            'carou_dir' => $this->carou_dir
        ]);
    }


    /**
     * @Route("/manager/carousel/showcontent/{id}", name="app_carouseldetails")
     */
    public function contentcarousel($id)
    {
        $carousel = $this->carouselRepo->findOneBy(['id'=>$id]);
        return $this->render('manager/editcarousel.html.twig',[
            'carou' => $carousel,
            'carou_dir' => $this->carou_dir
        ]);
    }

    /**
     * @Route("/manager/carouselsave/{id}", name="app_carouselsave")
     */
    public function carouselsave($id)
    {
        if(!empty($_POST['description']))
        {
            $caroutoedit = $this->carouselRepo->findOneBy(['id'=>$id]);
            $caroutoedit->setDescription($_POST['description']);

            //Au cas où l'image de l'artice a ete modifiee (Documentation symfony)
            if (isset($_FILES['image']) && !empty($_FILES['image']['tmp_name']) == true )
            {
                $dir = $this->getParameter('carousel_dir');
                /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
                $file = $_FILES['image'];
                $fileName = $this->globals->generateUniqueFileName().'.'.pathinfo($file['name'],PATHINFO_EXTENSION);
                move_uploaded_file($file['tmp_name'], $dir.$fileName);
                $caroutoedit -> setImage($fileName);
            }
            //La persistance des donneess
            $this->globals->em()->persist($caroutoedit);
            $this->globals->em()->flush();
            return $this->redirectToRoute('app_carousel');
        }else
            return  $this->redirectToRoute('app_carousel');
    }

}