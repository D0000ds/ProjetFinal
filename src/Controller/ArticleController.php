<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    #[Route('/article/{id}', name: 'detail_article')]
    public function index($id, EntityManagerInterface $entityManager): Response
    {
        $article = $entityManager->getRepository(Article::class)->find($id);
        $moyennesNote = $entityManager->getRepository(Article::class)->moyennes();
        $produitSimilaires = $entityManager->getRepository(Article::class)->findBy(['categorie' => $article->getCategorie()->getId()], ['id' => 'DESC'], 5);
        $nbAvisEtCom = $entityManager->getRepository(Avis::class)->nbAvisEtCommentaire($id);

        return $this->render('article/index.html.twig', [
            'article' => $article,
            'moyennes' =>  $moyennesNote,
            'produitSimilaires' => $produitSimilaires,
            'nbAvisEtCom' => $nbAvisEtCom,
        ]);
    }
}
