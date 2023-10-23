<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $articles = $entityManager->getRepository(Article::class)->findBy([], ["id" => "DESC"]);
        $bestArticles = $entityManager->getRepository(Article::class)->findBy([], ["id" => "DESC"]);

        $moyennesNote = $entityManager->getRepository(Article::class)->moyennes();
        
        return $this->render('home/index.html.twig', [
            'articles' => $articles,
            'moyennes' =>  $moyennesNote,
        ]);
    }
}
