<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Adresse;
use App\Entity\Commande;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    #[Route('/profile', name: 'app_user')]
    public function index(EntityManagerInterface $entityManager,SessionInterface $session,): Response
    {
        $clients = $entityManager->getRepository(User::class)->findAll();
        $commande = $entityManager->getRepository(Commande::class)->findBy(['client' => $this->getUser()->getId()]);

        return $this->render('user/index.html.twig', [
            'clients' => $clients,
            'commande' => $commande,
        ]);
    }
}
