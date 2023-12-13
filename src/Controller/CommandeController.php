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

        $commandes = $entityManager->getRepository(Commande::class)->semaine($this->getUser()->getId(), $dateAjd, $dateObj);

        return $this->render('commande/index.html.twig', [
            'commandes' => $commandes,
        ]);
    }

    #[Route('/commande/mois', name: 'app_commande_mois')]
    public function mois(EntityManagerInterface $entityManager): Response
    {
        $dateAjd = new DateTime();
        $mois =  date('d/m/Y', strtotime('-1 month'));
        $dateObj = DateTime::createFromFormat('d/m/Y', $mois);

        $commandes = $entityManager->getRepository(Commande::class)->mois($this->getUser()->getId(), $dateAjd, $dateObj);

        return $this->render('commande/index.html.twig', [
            'commandes' => $commandes,
        ]);
    }

    #[Route('/commande/annee', name: 'app_commande_annee')]
    public function annee(EntityManagerInterface $entityManager): Response
    {
        $dateAjd = new DateTime();
        $annee =  date('d/m/Y', strtotime('-1 year'));
        $dateObj = DateTime::createFromFormat('d/m/Y', $annee);

        $commandes = $entityManager->getRepository(Commande::class)->annee($this->getUser()->getId(), $dateAjd, $dateObj);

        return $this->render('commande/index.html.twig', [
            'commandes' => $commandes,
        ]);
    }

    #[Route('/commande/VoirClickAndCollect', name: 'app_commande_VoirClickAndCollect')]
    public function VoirClickAndCollect(EntityManagerInterface $entityManager): Response
    {
        $commandes = $entityManager->getRepository(Commande::class)->findBy(["clickAndCollect" => true, "valider" => null]);

        return $this->render('commande/VoirClickAndCollect.html.twig', [
            'commandes' => $commandes,
        ]);
    }

    #[Route('/commande/VoirClickAndCollect/valider/{id}', name: 'app_commande_VoirClickAndCollect_valider')]
    public function valider($id, EntityManagerInterface $entityManager): Response
    {
        
        $commande = $entityManager->getRepository(Commande::class)->find($id);
        
        $commande->setValider(true);

        $entityManager->persist($commande);
        $entityManager->flush();
    
        return $this->redirectToRoute('app_commande_VoirClickAndCollect');
    }

    #[Route('/commande/votreClickAndCollect', name: 'app_commande_VotreClickAndCollect')]
    public function VotreClickAndCollect(EntityManagerInterface $entityManager): Response
    {
        $commandes = $entityManager->getRepository(Commande::class)->findBy(["client" => $this->getUser()->getId(),"clickAndCollect" => true, "valider" => null]);
        

        return $this->render('commande/index.html.twig', [
            'commandes' => $commandes,
        ]);
    }

}
