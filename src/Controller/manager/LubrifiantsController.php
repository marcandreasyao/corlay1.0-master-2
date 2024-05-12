<?php

namespace App\Controller\manager;

use App\Entity\Declinaisons;
use App\Entity\Lubrifiants;
use App\Repository\LubrifiantsRepository;
use App\Repository\DeclinaisonsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Utils\Globals;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class LubrifiantsController extends AbstractController
{
    public LubrifiantsRepository $lubrifiantsRepo;
    public DeclinaisonsRepository $declinaisonsRepo;
    public Globals $globals;

    private $lubri_dir = 'client/img/lubrifiants/';

    public function __construct(LubrifiantsRepository $lubrifiantsRepo, DeclinaisonsRepository $declinaisonsRepo,
                                Globals $globals)
    {
        $this->lubrifiantsRepo = $lubrifiantsRepo;
        $this->declinaisonsRepo = $declinaisonsRepo;
        $this->globals = $globals;

    }

    /**
     * @Route("/manager/lubrifiants", name="app_lubrifiants")
     */
    public function lublist():Response
    {
        $lubrifiants = $this->lubrifiantsRepo->findAll();
        return $this->render('manager/lubri.html.twig',[
            'lubris' => $lubrifiants
        ]);
    }


    /**
     * @Route("/manager/lubrifiants/declinaisons/{id}", name="app_declinaisons")
     */
    public function declinaisons($id):Response
    {
        $declinaisons = $this->declinaisonsRepo->findBy(['fk_lubrifiant' => $id]);
        $lubrifiant = $this->lubrifiantsRepo->findOneBy(['id' => $id]);
        return $this->render('manager/declinaisons.html.twig',[
            'declis' => $declinaisons,
            'lubri' => $lubrifiant
        ]);
    }


    /**
     * @Route("/manager/lubrifiantsupdate/{id}", name="app_lubriupdate")
     */
    public function lubrifyupdate($id){
        $lubritedit =$this->lubrifiantsRepo->findOneBy(['id' => $id]);
        if($lubritedit){
            if(isset($_POST['nomlub']) && isset($_POST['description']))
            {
                $lubritedit->setLubName($_POST['nomlub'])
                           ->setLubDescription($_POST['description']);
                $this->globals->em()->persist($lubritedit);
                $this->globals->em()->flush();
                return $this->redirectToRoute('app_declinaisons',array('id' => $id));
            }
        }else
        return $this->redirectToRoute('app_lubrifiants');
    }


    /**
     * @Route("/manager/lubrifiants/editdeclinaison/{id}", name="app_declinaisonedit")
     */
    public function editdeclinaison($id)
    {
        $ladeclinaison = $this->declinaisonsRepo->findOneBy(['id' => $id]);
        return $this->render('manager/declinaisonscreen.html.twig',[
           'decline'=> $ladeclinaison,
            'lub_dir' => $this->lubri_dir
        ]);
    }


    /**
     * @Route("/manager/lubrifiants/decliupdate/{id}", name="declin_update")
     */
    public function saveupdatedeclinaison($id)
    {
        $declinaisontoupdate = $this->declinaisonsRepo->findOneBy(['id' => $id]);
        if($declinaisontoupdate)
        {
            if(isset($_POST['nom']) && isset($_POST['grade']) && isset($_POST['performance']) && $_POST['emballage'] && $_POST['technique'])
            {
                $declinaisontoupdate ->setNom($_POST['nom'])
                                     ->setGrade($_POST['grade'])
                                     ->setPerformance($_POST['performance'])
                                     ->setEmballage($_POST['emballage'])
                                     ->setFichetechnique($_POST['technique']);

                //Au cas où l'image de l'artice a ete modifiee (Documentation symfony)
                if(isset($_FILES['image']) && !empty($_FILES['image']['tmp_name']) == true)
                {
                    $dir = $this->getParameter('lubrifiants_photo');
                    /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
                    $file = $_FILES['image'];
                    $fileName = $this->generateUniqueFileName().'.'.pathinfo($file['name'],PATHINFO_EXTENSION);
                    move_uploaded_file($file['tmp_name'], $dir.$fileName);
                    $declinaisontoupdate -> setApercu($fileName);
                }
                //Persistance des donnees
                $this->globals->em()->persist($declinaisontoupdate);
                $this->globals->em()->flush();
                return $this->redirectToRoute('app_declinaisonedit',array('id' => $id));
            }
        }
        return $this->redirectToRoute('app_lubrifiants');
    }


    /**
     * @Route("/manager/lubrifiants/declisave/{id}", name="declin_save")
     */
    public function savedeclinaison($id)
    {
        $category = $this->lubrifiantsRepo->findOneBy(['id'=>$id]);
        if(isset($_POST['nom']) && isset($_POST['grade']) && isset($_POST['performance']) && $_POST['emballage'] && $_POST['technique']) {
            $declinaisontosave = new Declinaisons();
            $declinaisontosave->setNom($_POST['nom'])
                 ->setGrade($_POST['grade'])
                 ->setPerformance($_POST['performance'])
                 ->setEmballage($_POST['emballage'])
                 ->setFichetechnique($_POST['technique']);

            //Au cas où l'image de a ete modifiee (Documentation symfony)
            if (isset($_FILES['image']) && !empty($_FILES['image']['tmp_name'])) {
                $dir = $this->getParameter('lubrifiants_photo');
                /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
                $file = $_FILES['image'];
                $fileName = $this->generateUniqueFileName() . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
                move_uploaded_file($file['tmp_name'], $dir . $fileName);
                $declinaisontosave->setApercu($fileName);
            }
            $declinaisontosave->setFkLubrifiant($category);

            //Persistance des donnees
            $this->globals->em()->persist($declinaisontosave);
            $this->globals->em()->flush();
            return $this->redirectToRoute('app_declinaisons', array('id' => $id));
        }else
        return $this->redirectToRoute('app_add_declinaison', array('id'=>$id));
    }


    /**
     * @Route("/manager/lubrifiants/newdeclinaison/catlub={id}", name="app_add_declinaison")
     */
    public function adddeclinaison($id)
    {
        $lacategorie = $this->lubrifiantsRepo->findOneBy(['id' => $id]);
        return $this->render('manager/declinaisonsave.html.twig',[
            'cat' => $lacategorie
        ]);
    }


    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/manager/lubrifiants/declinaisondelete/decli={id}&catlub={cat}", name="app_delete_declinaison")
     */
    public function deletedeclinaison($id,$cat)
    {
        $declitodelete = $this->declinaisonsRepo->findOneBy(['id' => $id]);
        if($declitodelete)
        {
            $this->globals->em()->remove($declitodelete);
            $this->globals->em()->flush();
            return $this->redirectToRoute('app_declinaisons',array('id'=>$cat));
        }
        return $this->redirectToRoute('app_declinaisons',array('id'=>$cat));
    }

    /**
     * @Route("/manager/lubrifiants/catsave", name="app_category_save")
     */
    public function categorysave()
    {
        if(isset($_POST['catname']) && isset($_POST['libdesc']))
        {
            $newcategoy = new Lubrifiants();
            $newcategoy->setLubName($_POST['catname'])
                       ->setLubDescription($_POST['libdesc']);

            //Persistance des données
            $this->globals->em()->persist($newcategoy);
            $this->globals->em()->flush();
            return $this->redirectToRoute('app_lubrifiants');
        }else
            return $this->redirectToRoute('app_lubrifiants');
    }


    /**
     * @Route("/manager/lubrifiants/catdelete/{id}", name="app_category_delete")
     */
    public function deletecategory($id)
    {
       $declinaisons = $this->declinaisonsRepo->findBy(['fk_lubrifiant'=>$id]);
       $lubrifiant = $this->lubrifiantsRepo->findOneBy(['id'=>$id]);
       if($declinaisons)
       {
           foreach ($declinaisons as $declinaison)
           {
               $this->globals->em()->remove($declinaison);
               $this->globals->em()->flush();
           }
       }
       $this->globals->em()->remove($lubrifiant);
       $this->globals->em()->flush();
       return $this->redirectToRoute('app_lubrifiants');
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