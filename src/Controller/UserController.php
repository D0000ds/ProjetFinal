<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Adresse;
use App\Entity\Commande;
use App\Entity\CommandeArticle;
use App\Form\EditPasswordFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;



class UserController extends AbstractController
{
    #[Route('/profile', name: 'app_user')]
    public function index(EntityManagerInterface $entityManager,SessionInterface $session,): Response
    {
        $clients = $entityManager->getRepository(User::class)->findAll();
        $commande = $entityManager->getRepository(Commande::class)->findBy(['client' => $this->getUser()->getId()]);
        $moyenneSatisfaction = $entityManager->getRepository(User::class)->moyenneAvis($this->getUser()->getId());
        $adressePrincipale = $entityManager->getRepository(Adresse::class)->findBy(['client' => $this->getUser()->getId()], ["id" => "ASC"], '1');
        $adresseSecondaire = $entityManager->getRepository(Adresse::class)->findBy(['client' => $this->getUser()->getId()], ["id" => "ASC"], null, 1);

        return $this->render('user/index.html.twig', [
            'clients' => $clients,
            'moyenneSatisfaction' => $moyenneSatisfaction,
            'adressePrincipales' => $adressePrincipale,
            'adresseSecondaires' => $adresseSecondaire,
        ]);
    }

    #[Route('/edit-password', name: 'edit_password_user')]
    public function editPassword(EntityManagerInterface $entityManager, Request $request, UserPasswordHasherInterface $userPasswordHasher):Response
    {
        $user = $entityManager->getRepository(User::class)->find($this->getUser()->getId());

        $form = $this->createForm(EditPasswordFormType::class, $user);


        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            if($userPasswordHasher->isPasswordValid($user, $form->get('plainPassword')->getData())){
                $newPassword = $form->get('newPassword')->getData();
                $hashedNewPassword = $userPasswordHasher->hashPassword($user, $newPassword);
                $user->setPassword($hashedNewPassword);

                $entityManager->persist($user);
                $entityManager->flush();

                $this->addFlash('sucess', 'Le mot de passe a été changer.');
                return $this->redirectToRoute('app_user');
            }else {
                $this->addFlash('warning', 'Mot de passe incorrect');
            }
        }

        return $this->render('user/editPassword.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/profile/edit', name: 'edit_user')]
    public function edit(){

    }

    #[Route('/profile/delete', name: 'delete_user')]
    public function delete(EntityManagerInterface $entityManager){
        $user = $entityManager->getRepository(User::class)->find($this->getUser()->getId());

        $user->setEmail("Delete");
        $user->setPassword("Delete");
        $user->setNewsLetter(false);
        $user->setIsVerified(false);
        $user->setTelephone("Delete");
        $user->setNom("Delete");
        $user->setPrenom("Delete");
        $this->container->get('security.token_storage')->setToken(null);

        $this->addFlash('sup', 'Votre compte a bien été supprimée');
        $entityManager->flush();

        return $this->redirectToRoute('app_home');
    }
}
