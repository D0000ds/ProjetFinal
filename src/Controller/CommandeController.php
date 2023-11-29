<?php

namespace App\Controller;

use DateTime;
use App\Entity\Commande;
use App\Entity\CommandeArticle;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommandeController extends AbstractController
{
    #[Route('/commande', name: 'app_commande')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $commandes = $entityManager->getRepository(Commande::class)->findBy(["client" => $this->getUser()->getId()], ["dateCommande" => "DESC"]);

        return $this->render('commande/index.html.twig', [
            'commandes' => $commandes,
        ]);
    }

    #[Route('/commande/semaine', name: 'app_commande_semaine')]
    public function semaine(EntityManagerInterface $entityManager): Response
    {
        $dateAjd = new DateTime();
        $semaine =  date('d/m/Y', strtotime('-7 days'));
        $dateObj = DateTime::createFromFormat('d/m/Y', $semaine);


        $commandes = $entityManager->getRepository(Commande::class)->findBy(["client" => $this->getUser()->getId(), "dateCommande" => ['between' => $dateObj->format('Y-m-d'), $dateAjd->format('Y-m-d')]], ["dateCommande" => "DESC"]);

        return $this->render('commande/index.html.twig', [
            'commandes' => $commandes,
        ]);
    }
}
