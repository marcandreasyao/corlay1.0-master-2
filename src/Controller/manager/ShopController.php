<?php

namespace App\Controller\manager;

use App\Entity\Boutique;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\BoutiqueRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Utils\Globals;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class ShopController extends AbstractController
{
    private $boutiques_dir = 'client/img/boutiques/';

    public BoutiqueRepository $boutiqueRepo;
    public Globals $globals;

    public function __construct(BoutiqueRepository $boutiqueRepo, Globals $globals)
    {
        $this->boutiqueRepo = $boutiqueRepo;
        $this->globals = $globals;
    }

    /**
     * @Route("/manager/shops", name="cshops")
     */
    public function shopList()
    {
        $shoplist = $this->boutiqueRepo->findAll();
        return $this->render('manager/shops.html.twig', [
            'controller_name' => 'ShopController',
            'boutiques' => $shoplist,
            'image_dir' => $this->boutiques_dir
        ]);
    }


    /**
     * @Route("/manager/shops/oneshop/{id}", name="edit_shop")
     */
    public function shopdetails ($id): Response
    {
        if(isset($id)) {
            $singleshop = $this->boutiqueRepo->findOneBy(['id' => $id]);
            return $this->render('manager/oneshop.html.twig', [
                'controller_name' => 'ShopController',
                'shop' => $singleshop,
                'shop_dir'=> $this->boutiques_dir
            ]);
        }else
            return  $this->redirectToRoute('cshops');
    }


    /**
     * @Route("/manager/shops/edit/{id}", name="edit_shop_submit")
     */
    public function editsubmit ($id): Response
    {
        if(isset($_POST['nom']) && isset($_POST['location']) && isset($_POST['ouvrir']) && isset($_POST['fermer']))
        {
            $nom = $_POST['nom']; $lieu = $_POST['location'];
            $ouvre = '2022-07-23 '.$_POST['ouvrir'].':00';
            $ferme = '2022-07-23 '.$_POST['fermer'].':00';
            $contact = $_POST['contacts'] ?? "";

            //Creation des datetimeInterface
            $opening = DateTime::createFromFormat("Y-m-d H:i:s", $ouvre);
            $closing = DateTime::createFromFormat("Y-m-d H:i:s", $ferme);

            //on recherche la boutique à modifier
            $shoptoedit = $this->boutiqueRepo->findOneBy(['id' => $id]);
            if($shoptoedit)
            {
                $shoptoedit->setNom($nom)
                            ->setEmplacement($_POST['location'])
                            ->setOuverture($opening)
                            ->setFermeture($closing)
                            ->setContacts($contact);

                //upload d'image
                if (isset($_FILES['image']) && !empty($_FILES['image']['tmp_name']) == true ) {
                    $dir = $this->getParameter('shops_dir');
                    /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
                    $file = $_FILES['image'];
                    $fileName = $this->generateUniqueFileName().'.'.pathinfo($file['name'],PATHINFO_EXTENSION);
                    move_uploaded_file($file['tmp_name'], $dir.$fileName);
                    if(file_exists($dir.$shoptoedit->getImage()))
                        unlink($dir.$shoptoedit->getImage());
                    $shoptoedit -> setImage($fileName);
                }
            }
            $this->globals->em()->persist($shoptoedit);
            $this->globals->em()->flush();
            return $this->redirectToRoute('edit_shop',array('id'=>$id));
        }else
            return $this->redirectToRoute('cshops');
    }


    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/manager/shops/delete/{id}", name="app_shop_delete")
     */
    public function deleteshop($id)
    {
        $shoptodelete = $this->boutiqueRepo->findOneBy(['id'=>$id]);
        if($shoptodelete)
        {
            $dir = $this->getParameter('shops_dir');
            if(file_exists($dir.$shoptodelete->getImage()))
                unlink($dir.$shoptodelete->getImage());
            $this->globals->em()->remove($shoptodelete);
            $this->globals->em()->flush();
            return $this->redirectToRoute('cshops');
        }else
            return $this->redirectToRoute('cshops');
    }


    /**
     * @Route("/manager/newshop", name="app_new_shop")
     */
    public function nouvelleboutique()
    {
        return $this->render('manager/saveshop.html.twig');
    }


    /**
    * @Route("/manager/shops/saveshop", name="app_shop_save")
    */
    public function saveshop (): Response
    {
        if(isset($_POST['nom']) && isset($_POST['location']) && isset($_POST['ouvrir']) && isset($_POST['fermer']))
        {
            $nom = $_POST['nom']; $lieu = $_POST['location'];
            $ouvre = '2022-07-23 '.$_POST['ouvrir'].':00';
            $ferme = '2022-07-23 '.$_POST['fermer'].':00';
            $contact = $_POST['contacts'] ?? "";

            //Creation des datetimeInterface
            $opening = DateTime::createFromFormat("Y-m-d H:i:s", $ouvre);
            $closing = DateTime::createFromFormat("Y-m-d H:i:s", $ferme);
                $newshop = new Boutique();
                $newshop->setNom($nom)
                    ->setEmplacement($_POST['location'])
                    ->setOuverture($opening)
                    ->setFermeture($closing)
                    ->setContacts($contact);

                //upload d'image
                if (isset($_FILES['image']) && !empty($_FILES['image']['tmp_name']) == true ) {
                    $dir = $this->getParameter('shops_dir');
                    /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
                    $file = $_FILES['image'];
                    $fileName = $this->generateUniqueFileName().'.'.pathinfo($file['name'],PATHINFO_EXTENSION);
                    move_uploaded_file($file['tmp_name'], $dir.$fileName);
                    $newshop -> setImage($fileName);
                }
            $this->globals->em()->persist($newshop);
            $this->globals->em()->flush();
            return $this->redirectToRoute('cshops');
        }else
            return $this->redirectToRoute('cshops');
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