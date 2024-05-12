<?php

namespace App\Controller\manager;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ArticlesRepository;
use App\Utils\Globals;
use App\Entity\Articles;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class ActusController extends AbstractController
{
    public ArticlesRepository $articlesRepo;
    public Globals $globals;
    private $miniature_dir ='client/img/blog/';

    public function __construct(ArticlesRepository $articlesRepo, Globals $globals){
        $this->articlesRepo = $articlesRepo;
        $this->globals = $globals;
    }


    /**
     * @Route ("/manager/articles", name="article_manager")
     */
    public function listeArticles():Response
    {
        $articleslist = $this->articlesRepo->findBy(array(),array('date' => 'DESC'));
        return $this->render('manager/blog.html.twig',[
            'controller_name' => 'ActusController',
            'news' => $articleslist,
            'image_dir' => $this->miniature_dir
        ]);
    }


    /**
     * @Route("/manager/article/editarticle/{id}", name="edit_article")
     */
    public function articleedit ($id): Response
    {
        if(isset($id)) {
            $singlepost = $this->articlesRepo->findBy(['id' => $id]);
            return $this->render('manager/editarticle.html.twig', [
                'controller_name' => 'DefaultController',
                'post' => $singlepost[0],
                'image_dir' => $this->miniature_dir
            ]);
        }
    }



    /**
     * @Route("/manager/article/modifsubit", name="submitmodif")
     */
    public function dbmodifarticle():Response
    {
        if(isset($_POST['edit'])) {
            if (isset($_POST['titre']) && isset($_POST['preview']) && isset($_POST['content'])) {

                $identifiant = $_POST['id'];$title = $_POST['titre'];
                $apercu = $_POST['preview'];$contenu = $_POST['content'];

                //Recherche de l'article à modifier
                $articletoedit = $this->articlesRepo->findOneBy(['id' => $identifiant]);
                $articletoedit->setTitle($title)
                              ->setPreview($apercu)
                              ->setContent($contenu);

                //Au cas où l'image de l'artice a ete modifiee (Documentation symfony)
                if (isset($_FILES['image']) && !empty($_FILES['image']['tmp_name']) == true ) {
                    $dir = $this->getParameter('image_blog');
                    /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
                    $file = $_FILES['image'];
                    $fileName = $this->generateUniqueFileName().'.'.pathinfo($file['name'],PATHINFO_EXTENSION);
                    move_uploaded_file($file['tmp_name'], $dir.$fileName);
                    if(file_exists($dir.$articletoedit->getImage()))
                        unlink($dir.$articletoedit->getImage());
                    $articletoedit -> setImage($fileName);
                }
                //Persistance des donnees
                $this->globals->em()->persist($articletoedit);
                $this->globals->em()->flush();
                return $this->redirectToRoute('article_manager');
            }
        }
    }



    /**
     * @Route("/manager/article/newarticle", name="app_nouvelarticle")
     */
    public function navigatetonew()
    {
        return $this->render('manager/articlesave.html.twig');
    }


    /**
     * @Route("/manager/article/articlepush", name="articlesave")
     */
    public function save():Response
    {
        if(isset($_POST['titre']) && isset($_POST['preview']) && isset($_POST['content']))
        {
            $title = $_POST['titre'];
            $apercu = $_POST['preview'];$contenu = $_POST['content'];

           //Recherche de l'article à modifier
           $articletosave = new Articles();
           $articletosave ->setTitle($title)
                          ->setPreview($apercu)
                          ->setDate(new DateTime)
                          ->setContent($contenu);

           //Au cas où l'image de l'artice a ete modifiee (Documentation symfony)
           if(isset($_FILES['image']) && !empty($_FILES['image']['tmp_name']) == true )
           {
               $dir = $this->getParameter('image_blog');
               /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
               $file = $_FILES['image'];
               $fileName = $this->generateUniqueFileName().'.'.pathinfo($file['name'],PATHINFO_EXTENSION);
               move_uploaded_file($file['tmp_name'], $dir.$fileName);
               $articletosave -> setImage($fileName);
           }
           //Persistance des donnees
            $this->globals->em()->persist($articletosave);
            $this->globals->em()->flush();
            return $this->redirectToRoute('article_manager');
        }else
            return  $this->redirectToRoute('app_nouvelarticle');
    }


    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("manager/article/delete/{id}", name="app_article_delete")
     */
    public function deletearticle($id)
    {
        $articletodelete = $this->articlesRepo->findOneBy(['id' => $id]);
         if($articletodelete)
         {
             $dir = $this->getParameter('image_blog');
             if(file_exists($dir.$articletodelete->getImage()))
                 unlink($dir.$articletodelete->getImage());
             $this->globals->em()->remove($articletodelete);
             $this->globals->em()->flush();
             return $this->redirectToRoute('article_manager');
         }
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

}