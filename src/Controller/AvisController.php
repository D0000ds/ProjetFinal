<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
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
}
