<?php

namespace App\Controller\manager;

use App\Entity\Couts;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\CoutsRepository;
use App\Utils\Globals;
use Symfony\Component\Routing\Annotation\Route;
use Datetime;

class CostController extends AbstractController
{
    public CoutsRepository $coutsRepo;
    public Globals $globals;

    public function __construct(CoutsRepository $coutsRepo, Globals $globals)
    {
        $this->globals = $globals;
        $this->coutsRepo = $coutsRepo;
    }

    /**
     * @Route("/manager/prices", name="app_costs")
     */
    public function costsmanager ()
    {
        $costschecker = $this->costsUpdate();
        $prix = $this->coutsRepo->findOneBy([], ['id' => 'desc']);
        return $this->render('manager/prices.html.twig',[
            'prices' => $prix
        ]);
    }


    /**
     * @Route("/manager/prices/update/{id}", name="price_save")
     */
    public function updateprice($id)
    {
        if(isset($_POST['super']) && isset($_POST['gasoil']) && isset($_POST['petrole']) && isset($_POST['ddo']) && isset($_POST['ddoad'])
            && isset($_POST['butane']) && isset($_POST['bt6']) && isset($_POST['bt12']) && isset($_POST['fuel']) && isset($_POST['btc']))
        {
            $costs = $this->coutsRepo->findOneBy(['id'=> $id]);
            if($costs)
            {
                $costs->setSuper($_POST['super'])
                      ->setGasoil($_POST['gasoil'])
                      ->setPetrole($_POST['petrole'])
                      ->setDdo($_POST['ddo'])
                      ->setDdoad($_POST['ddoad'])
                      ->setButane($_POST['butane'])
                      ->setBtc($_POST['btc'])
                      ->setBt6kg($_POST['bt6'])
                      ->setBt12kg($_POST['bt12'])
                      ->setFuel($_POST['fuel']);

                //Persistance des donnees
                $this->globals->em()->persist($costs);
                $this->globals->em()->flush();
                return $this->redirectToRoute('app_costs');
            }

        }else
            return $this->redirectToRoute('app_costs');
    }

    /**
     * @param $annee
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/manager/prices/details/{annee}", name="annee_details")
     */
    public function yeardetails($annee)
    {
        $details = $this->coutsRepo->findBy(['annee'=>$annee]);
        return $this->render('manager/pricesdetails.html.twig',[
            'details' => $details,
            'year' => $annee
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|void
     * @Route("/manager/detailfromyear", name="typedyear")
     */
    public function customyear()
    {
        if(isset($_POST['customyear']))
            return $this->redirectToRoute('annee_details',array('annee'=>$_POST['customyear']));
    }

    /**
     * @return void
     */
    public function costsUpdate()
    {
        $lastcost = $this->coutsRepo->findOneBy([], ['id' => 'desc']);
        $today = new DateTime();
        $result = $today->format('Y-m-d');
        $annee = substr($result,0,4);
        $mois = substr($result,5,2);
        $currentlibelle = $this->globals->monthFromDate($mois).' '.$annee;

        if($currentlibelle !== $lastcost->getLibelle())
        {
            $nouveumois = new Couts();
            $nouveumois ->setSuper($lastcost->getSuper())
                        ->setGasoil($lastcost->getGasoil())
                        ->setPetrole($lastcost->getPetrole())
                        ->setDdo($lastcost->getDdo())
                        ->setDdoad($lastcost->getDdoad())
                        ->setButane($lastcost->getButane())
                        ->setBtc($lastcost->getBtc())
                        ->setBt6kg($lastcost->getBt6kg())
                        ->setBt12kg($lastcost->getBt12kg())
                        ->setFuel($lastcost->getFuel())
                        ->setDate($today)
                        ->setLibelle($currentlibelle)
                        ->setAnnee(date("Y"));
            $this->globals->em()->persist($nouveumois);
            $this->globals->em()->flush();
        }

    }

}