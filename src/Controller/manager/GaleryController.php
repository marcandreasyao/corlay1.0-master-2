<?php

namespace App\Controller\manager;

use App\Entity\Photos;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PhotosRepository;
use App\Entity\Albums;
use App\Repository\AlbumsRepository;
use App\Utils\Globals;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class GaleryController extends AbstractController
{

    private $albums_mini = 'client/img/galery/miniatures/';
    private $dossier_photo = 'client/img/galery/';

    public AlbumsRepository $albumsRepo;
    public PhotosRepository $photosRepo;
    public Globals $globals;

    public function __construct(AlbumsRepository $albumsRepo, Globals $globals, PhotosRepository $photosRepo)
    {
        $this->albumsRepo = $albumsRepo;
        $this->photosRepo = $photosRepo;
        $this->globals = $globals;
    }

    /**
     * @Route("/manager/galery", name="app_galery")
     */
    public function albums():Response
    {
        $albums = $this->albumsRepo->findALL();
        return $this->render('manager/albums.html.twig',[
            'ControllerName' =>'AlbumController',
            'albums' => $albums,
            'miniature_dir' => $this->albums_mini
        ]);
    }


    /**
     * @Route("/manager/galery/createalbum", name="app_createalbum")
     */
    public function albumsave():Response
    {
        if(!empty($_POST['albumname']) && !empty($_FILES['miniature']))
        {
            $datedujour = new \DateTime();
            $nouvelalbum = new Albums();
            $nouvelalbum->setNomalbum($_POST['albumname'])
                        ->setDate($datedujour);
            $dir = $this->getParameter('mini_galery');

            //Upload d'image
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $_FILES['miniature'];
            $fileName = $this->generateUniqueFileName().'.'.pathinfo($file['name'],PATHINFO_EXTENSION);
            move_uploaded_file($file['tmp_name'], $dir.$fileName);
            $nouvelalbum -> setMiniature($fileName);

            //Persistance des données
            $this->globals->em()->persist($nouvelalbum);
            $this->globals->em()->flush();
            $lastId = $nouvelalbum->getId();
            return $this->redirectToRoute('editgalery', array('id' => $lastId));
        }else
            return $this->redirectToRoute('app_galery');
    }


    /**
     * @Route("/manager/galery/albumcontent/{id}", name="editgalery")
     */
    public function contenuAlbum($id)
    {
        if(isset($id))
        {
            $contenualbum = $this->photosRepo->findBy(['fk_albums'=>$id]);
            $this->album_id = $id;
            return $this->render('manager/editalbum.html.twig',[
                'contenu' => $contenualbum,
                'photo_dir' => $this->dossier_photo,
                'album_id' => $id
            ]);
        }
    }


    /**
     * @Route("/manager/galery/albumupdate/{id}", name="pushphotos")
     */
    public function updatealbum($id)
    {
        if (isset($_FILES['files'])) {
            $selectedalbum = $this->albumsRepo->findOneBy(['id' => $id]);
            $dir = $this->getParameter('galerie_photo');
            $nbLignes = count($_FILES['files']['name']);
            for ($i = 0; $i < $nbLignes; $i++) {
                $photo = new Photos();
                /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
                $file = $_FILES['files'];
                $fileName = $this->generateUniqueFileName() . '.' . pathinfo($file['name'][$i], PATHINFO_EXTENSION);
                move_uploaded_file($file['tmp_name'][$i], $dir . $fileName);
                $photo->setImagename($fileName)
                    ->setFkAlbums($selectedalbum);
                $this->globals->em()->persist($photo);
                $this->globals->em()->flush();
            }
            $selectedalbum->setNbrephotos($this->countitems($id));
            $this->globals->em()->persist($selectedalbum);
            $this->globals->em()->flush();

            return $this->redirectToRoute('editgalery', array('id' => $id));
        }else
           return $this->redirectToRoute('app_galery');
    }


    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/manager/galery/deletealbum/{id}", name="deletealbum")
     */
    public function deletealbum($id)
    {
        $photos = $this->photosRepo->findBy(['fk_albums'=>$id]);
        $album = $this->albumsRepo->findOneBy(['id'=>$id]);
        if($photos)
        {
            foreach ($photos as $photo)
            {
                $dir = $this->getParameter('galerie_photo');
                if(file_exists($dir.$photo->getImagename()))
                    unlink($dir.$photo->getImagename());
                $this->globals->em()->remove($photo);
                $this->globals->em()->flush();
            }
        }
        if($album){
            $directory = $this->getParameter('mini_galery');
            if(file_exists($directory.$album->getMiniature()))
                unlink($directory.$album->getMiniature());
            $this->globals->em()->remove($album);
            $this->globals->em()->flush();
        }
        return $this->redirectToRoute('app_galery');
    }


    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }

    private function countitems($ident):int
    {
        $count = 0;
        $tofs = $this->photosRepo->findBy(['fk_albums'=>$ident]);
        if($tofs){
            foreach ($tofs as $tof)
                $count++;
        }
        return $count;
    }


}