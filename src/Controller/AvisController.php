<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Form\AvisType;
use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AvisController extends AbstractController
{
    #[Route('/avis/{id}', name: 'app_avis')]
    public function index($id, EntityManagerInterface $entityManager): Response
    {
        $article = $entityManager->getRepository(Article::class)->find($id);
        $moyennesNote = $entityManager->getRepository(Article::class)->moyennes();

        

        return $this->render('avis/index.html.twig', [
            'article' => $article,
            'moyennes' =>  $moyennesNote,
        ]);
    }

    #[Route('/avis/post/{id}', name: 'post_avis')]
    public function posterAvis($id, EntityManagerInterface $entityManager, Request $request): Response
    {
        $article = $entityManager->getRepository(Article::class)->find($id);
        $nb = 0;
        
        foreach($article->getAvis() as $articleAvis){
            $nb += 1;
        }

        $form = $this->createForm(AvisType::class);
        $form->handleRequest($request);

        return $this->render('avis/postAvis.html.twig', [
            'form' => $form->createView(),
            'article' => $article,
            'nb' => $nb + 1,
        ]);
    }
}
