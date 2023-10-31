<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Origine;
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
}
