<?php

namespace App\Controller\manager;

use App\Entity\Tlogin;
use App\Repository\TloginRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Utils\Globals;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
class ProfileController extends AbstractController
{
    private Security $security;
    private TloginRepository $tloginRepo;
    private Globals $globals;


    public function __construct(Security $security, TloginRepository $tloginRepo, Globals $globals)
    {
        $this->globals = $globals;
        $this->tloginRepo = $tloginRepo;
        $this->security = $security;
    }

    /**
     * @Route("/mamanger/myprofile/{error}", name="app_userprofile")
     */
    public function userprofile($error =0)
    {
        return $this->render('manager/userprofile.html.twig',[
           'moi'=>$this->security->getUser(),
            'checker' =>$error
        ]);
    }

    /**
     * @Route("/manager/profileupdate", name="app_profileupdate")
     */
    public function updateprofile(UserPasswordHasherInterface $passwordHasher)
    {
        $utilisateur = $this->security->getUser();
        $oldpassword = $_POST['oldpwd'];

        if (!empty($_POST['oldpwd']) && !empty($_POST['newpassword']))
        {
            $checkpass = $passwordHasher->isPasswordValid($utilisateur,$oldpassword);
            if($checkpass === true) {
                $hashedpassword = $passwordHasher->hashPassword($utilisateur, $_POST['newpassword']);
                $utilisateur->setPassword($hashedpassword);
            }else
                return $this->redirectToRoute('app_userprofile',array('error'=>1));
        }
            $utilisateur->setNom($_POST['nom'])
                ->setPrenoms($_POST['prenoms']);
            $this->globals->em()->persist($utilisateur);
            $this->globals->em()->flush();
            return $this->redirectToRoute('app_userprofile',array('error'=>2));
        }
    }