<?php

namespace App\Controller\manager;

use App\Entity\Partners;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\PartnersRepository;
use App\Utils\Globals;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class PartnersController extends AbstractController
{
    public PartnersRepository $partnersRepo;
    public Globals $globals;
    private $partner_dir = 'client/img/partners/';

    public function __construct(PartnersRepository $partnersRepo, Globals $globals)
    {
        $this->globals = $globals;
        $this->partnersRepo = $partnersRepo;
    }

    /**
     * @Route("/manager/partners/partnerslist", name="app_partnerslist")
     */
    public function partnerslist()
    {
        $partners = $this->partnersRepo->findAll();
        return $this->render('manager/partners.html.twig',[
            'partenaires' => $partners,
            'partner_dir' => $this->partner_dir
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/manager/partners/deletepartner/{id}", name="app_partnerdelete")
     */
    public function deletepartner($id)
    {
        $partnertodelete = $this->partnersRepo->findOneBy(['id'=>$id]);
        if($partnertodelete)
        {
            $dir = $this->getParameter('partners_dir');
            if(file_exists($dir.$partnertodelete->getImage()));
                unlink($dir.$partnertodelete->getImage());

            $this->globals->em()->remove($partnertodelete);
            $this->globals->em()->flush();
            return $this->redirectToRoute('app_partnerslist');
        }else
            return $this->redirectToRoute('app_partnerslist');
    }

    /**
     * @Route ("/manager/partners/savepartner", name="app_partnersave")
     */
    public function savepartner()
    {
        if(!empty($_POST['libpartner']) && isset($_FILES['image']) && !empty($_FILES['image']['tmp_name']) == true)
        {
            $newpartner = new Partners();
            $newpartner->setLibelle($_POST['libpartner']);

            //Upload d'image
            $dir = $this->getParameter('partners_dir');
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $_FILES['image'];
            $fileName = $this->globals->generateUniqueFileName().'.'.pathinfo($file['name'],PATHINFO_EXTENSION);
            move_uploaded_file($file['tmp_name'], $dir.$fileName);
            $newpartner -> setImage($fileName);

            //persistence des donnees
            $this->globals->em()->persist($newpartner);
            $this->globals->em()->flush();
            return $this->redirectToRoute('app_partnerslist');
        }else
            return $this->redirectToRoute('app_partnerslist');
    }

}