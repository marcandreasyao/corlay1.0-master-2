<?php

namespace App\Controller\manager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Videos;
use App\Repository\VideosRepository;
use App\Utils\Globals;
use DateTime;

class VideosController extends AbstractController
{
    private VideosRepository $videosRepo;
    private Globals $globals;
    private $albums_mini = 'client/img/galery/miniatures/';

    public function __construct(VideosRepository $videosRepo, Globals $globals)
    {
        $this->videosRepo = $videosRepo;
        $this->globals = $globals;
    }

    /**
     * @Route("/manager/videos/list", name="videoslist")
     */
    public function listofvideos()
    {
        $videos = $this->videosRepo->findAll();
        return $this->render('manager/videos.html.twig',[
            'videos' => $videos
        ]);
    }

    /**
     * @Route("/manager/videos/save", name="videosave")
     */
    public function savevideo()
    {
        if(isset($_POST['validate']))
        {
            $dir = $this->getParameter('mini_galery');
            $video = new Videos();
            $datedujour = new DateTime();
            $video ->setName($_POST['videotitle'])
                   ->setLink($_POST['videolink'])
                   ->setDate($datedujour);
            //Upload d'image
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $_FILES['miniature'];
            $fileName = $this->globals->generateUniqueFileName().'.'.pathinfo($file['name'],PATHINFO_EXTENSION);
            move_uploaded_file($file['tmp_name'], $dir.$fileName);
            $video -> setThumb($fileName);
            //Persistance des données
            $this->globals->em()->persist($video);
            $this->globals->em()->flush();
            return $this->redirectToRoute('videoslist');
        }else
            return $this->redirectToRoute('videoslist');
    }

    /**
     * @Route("/manager/videos/deletevideo/{id}", name="videodelete")
     */
    public function deletevideo($id)
    {
        $videotodelete = $this->videosRepo->findOneBy(['id'=>$id]);
        $directory = $this->getParameter('mini_galery');

        if(file_exists($directory.$videotodelete->getThumb()))
            unlink($directory.$videotodelete->getThumb());

        $this->globals->em()->remove($videotodelete);
        $this->globals->em()->flush();
        return $this->redirectToRoute('videoslist');
    }

}