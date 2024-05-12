<?php

namespace App\Controller\manager;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\StationsRepository;
use App\Entity\Stations;
use App\Utils\Globals;

class ManageStationController extends AbstractController
{
    private StationsRepository $stationsRepo;
    private Globals $globals;

    public function __construct(StationsRepository $stationsRepo, Globals $globals)
    {
        $this->globals =$globals;
        $this->stationsRepo = $stationsRepo;
    }

    /**
     * @Route("manager/stations/list", name="app_stationlist")
     */
    public function stationlist()
    {
        $stations = $this->stationsRepo->findAll();
        return $this->render('manager/stationslist.html.twig',[
            'stations' => $stations
        ]);
    }

    /**
     * @param $id
     * @Route("/manager/stations/deletestation/{id}", name="stationdelete")
     */
    public function deletestation($id):Response
    {
        $stationtodelete = $this->stationsRepo->findOneBy(['id'=>$id]);
        if($stationtodelete)
        {
            $this->globals->em()->remove($stationtodelete);
            $this->globals->em()->flush();
            return $this->redirectToRoute('app_stationlist');
        }else
            return $this->redirectToRoute('app_stationlist');
    }


    /**
     * @param $id
     * @Route("/manager/stations/onestation/{id}", name="onestation")
     */
    public function stationdetails($id)
    {
        $stationtoedit = $this->stationsRepo->findOneBy(['id'=>$id]);
        return $this->render('manager/editstation.html.twig',[
            'station' => $stationtoedit
        ]);
    }

    /**
     * @param $id
     * @Route("manager/stations/update/{id}", name="updatestation")
     */
    public function stationupdate($id)
    {
        $stationtoupdate = $this->stationsRepo->findOneBy(['id' => $id]);
        if ($stationtoupdate) {
            $stationtoupdate->setNom($_POST['nom'])
                ->setEmplacement($_POST['emplacement'])
                ->setFramecode($_POST['map'])
                ->setBt6($_POST['bt6'])
                ->setBt12($_POST['bt12'])
                ->setLubs($_POST["lubs"])
                ->setCshop($_POST['boutique'])
                ->setContacts($_POST['contacts']);
            $this->globals->em()->persist($stationtoupdate);
            $this->globals->em()->flush();
            return $this->redirectToRoute('onestation',array('id'=>$stationtoupdate->getId()));
        }else
            return $this->redirectToRoute('app_stationlist');
    }

    /**
     * @Route("manager/stations/newstation", name="newstation")
     */
    public function nouvellestation()
    {
        return $this->render('manager/newstation.html.twig');
    }


    /**
     * @Route("manager/stations/save", name="savestation")
     */
    public function stationsave()
    {
        if(isset($_POST['nom']) && isset($_POST['emplacement']))
        {
            $nouvellestation = new Stations();
            $nouvellestation->setNom($_POST['nom'])
                ->setEmplacement($_POST['emplacement'])
                ->setFramecode($_POST['map'])
                ->setBt6($_POST['bt6'])
                ->setBt12($_POST['bt12'])
                ->setLubs($_POST["lubs"])
                ->setCshop($_POST['boutique'])
                ->setContacts($_POST['contacts']);
            $this->globals->em()->persist($nouvellestation);
            $this->globals->em()->flush();
            return $this->redirectToRoute('app_stationlist');
        }else
            return $this->redirectToRoute('newstation');
    }
}