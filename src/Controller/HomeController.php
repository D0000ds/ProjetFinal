<?php

namespace App\Controller;

use DateTime;
use App\Entity\Article;
use App\Entity\Origine;
use App\Entity\Commande;
use App\Entity\Categorie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $articles = $entityManager->getRepository(Article::class)->findBy([], ["id" => "DESC"], 5);
        $bestArticles = $entityManager->getRepository(Article::class)->meilleuresVentes();
        $moyennesNote = $entityManager->getRepository(Article::class)->moyennes();
        $origines = $entityManager->getRepository(Origine::class)->findAll();

        return $this->render('home/index.html.twig', [
            'articles' => $articles,
            'moyennes' =>  $moyennesNote,
            'MeilleuresArticles' => $bestArticles,
            'origines' => $origines,
        ]);
    }

    #[Route('/admin', name: 'app_admin')]
    public function admin(EntityManagerInterface $entityManager): Response
    {
        $dateAjd = new DateTime();

        $ajd =  date('d/m/Y', strtotime('-1 days'));
        $semaine =  date('d/m/Y', strtotime('-7 days'));
        $mois =  date('d/m/Y', strtotime('-1 month'));
        $annee =  date('d/m/Y', strtotime('-1 year'));

        $dateObjSemaine = DateTime::createFromFormat('d/m/Y', $semaine);
        $dateObjMois = DateTime::createFromFormat('d/m/Y', $mois);
        $dateObjAnnee = DateTime::createFromFormat('d/m/Y', $annee);
        $dateObjAjd = DateTime::createFromFormat('d/m/Y', $ajd);

        $commandeAjd = $entityManager->getRepository(Commande::class)->date($dateAjd, $dateObjAjd);
        $commandeSemaine = $entityManager->getRepository(Commande::class)->date($dateAjd, $dateObjSemaine);
        $commandesMois = $entityManager->getRepository(Commande::class)->date($dateAjd, $dateObjMois);
        $commandesTotal = $entityManager->getRepository(Commande::class)->findAll();

        $countAjd = count($commandeAjd);
        $countSemaine = count($commandeSemaine);
        $countMois = count($commandesMois);
        $countTotal = count($commandesTotal);

        return $this->render('admin/index.html.twig', [
            'countSemaine' => $countSemaine,
            'countMois' => $countMois,
            'countTotal' => $countTotal,
            'countAjd' => $countAjd,
        ]);
    }
}