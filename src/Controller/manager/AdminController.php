<?php

namespace App\Controller\manager;

use App\Repository\TloginRepository;
use App\Utils\Globals;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Tlogin;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @IsGranted("ROLE_SUPER_ADMIN")
 * @Route("/manager/users", name="admin_")
 */
class AdminController extends AbstractController
{
    public TloginRepository $tloginRepo;
    public Globals $globals;
    public Security $security;

    public function __construct(TloginRepository $tloginRepo, Globals $globals, Security $security)
    {
        $this->globals = $globals;
        $this->tloginRepo = $tloginRepo;
        $this->security = $security;
    }

    /**
     * Liste des utilisteurs
     *
     * @Route("/list", name="userslist")
     */
    public function usersList($stat=0)
    {
        $users = $this->tloginRepo->findByRole("ROLE_SUPER_ADMIN");
        return $this->render('manager/admin/utilisateurs.html.twig', [
            'users' => $users,
            'moi' => $this->security->getUser(),
            'state' => $stat,
        ]);
    }


    /**
     * @Route("/edit/{id}", name="useredit")
     */
    public function edituser($id,TloginRepository $tloginRepo)
    {
        $utilisateur = $tloginRepo->findOneBy(['id'=>$id]);
        return $this->render('manager/admin/useredit.html.twig',[
            'user' => $utilisateur
        ]);
    }


    /**
     * @Route("/rolesupdate/{id}", name="updateroles")
     */
    public function updateroles($id, TloginRepository  $tloginRepository, Globals $globals)
    {
        $usertoedit = $tloginRepository->findOneBy(['id'=>$id]);
        if(isset($_POST['admincheck']))
        {
            $usertoedit ->setRoles(['ROLE_ADMIN']);
            $globals->em()->persist($usertoedit);
            $globals->em()->flush();
            return $this->redirectToRoute('admin_userslist');
        }else{
            $usertoedit ->setRoles([]);
            $globals->em()->persist($usertoedit);
            $globals->em()->flush();
            return $this->redirectToRoute('admin_userslist');
        }
    }

    /**
     * @Route("/newuser", name="newuser")
     */
    public function newuserform($check = 0)
    {
        return $this->render('manager/admin/newuser.html.twig',[
            'check' => $check
        ]);
    }

    /**
     * @Route("/saveuser", name="usersave")
     */
    public function usersave(UserPasswordHasherInterface $userPasswordHasher, Globals $globals)
    {
        $verif = $this->tloginRepo->findOneBy(['email'=>$_POST['username']]);
        if($verif)
        {
            return $this->newuserform(1);
        }else{
            $utilisateur = new Tlogin();
            $utilisateur->setNom($_POST['nom'])
                ->setPrenoms($_POST['prenoms'])
                ->setEmail($_POST['username'])
                ->setPassword($userPasswordHasher->hashPassword($utilisateur,$_POST['plainpassword']));
            $globals->em()->persist($utilisateur);
            $globals->em()->flush();
            return $this->usersList(1);
        }
    }

    /**
     * @Route("/deleteuser/{id}", name="deleteuser")
     */
    public function userdelete($id)
    {
        $usertodelete = $this->tloginRepo->findOneBy(['id'=>$id]);
        if($usertodelete)
        {
            $this->globals->em()->remove($usertodelete);
            $this->globals->em()->flush();
            return $this->redirectToRoute('admin_userslist');
        }
    }

}