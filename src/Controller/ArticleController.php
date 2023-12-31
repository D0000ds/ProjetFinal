<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Entity\Article;
use App\Form\ArticleType;
use App\Service\PictureService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    #[Route('/article/add', name: 'add_article')]
    public function add(EntityManagerInterface $entityManager, Request $request, PictureService $pictureService): Response
    {
        $form = $this->createForm(ArticleType::class);
        $form->handleRequest($request);

        $article = new Article();

        if($form->isSubmitted() && $form->isValid()){
            $image = $form->get('image')->getData();
            
            $fichier = $pictureService->add($image);

            $article = $form->getData();
            $article->setImage("Img/" . $fichier);
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin');
        }
    
        return $this->render('article/add.html.twig', [
            'form' => $form->createView(),
            'edit' => false,
        ]);
    }

    #[Route('/article/edit/{id}', name: 'edit_article')]
    public function edit($id,EntityManagerInterface $entityManager, Request $request, PictureService $pictureService): Response
    {
        $article = $entityManager->getRepository(Article::class)->find($id);

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){
            $image = $form->get('image')->getData();
            
            $fichier = $pictureService->add($image);

            $article = $form->getData();
            $article->setImage("Img/" . $fichier);
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('detail_article', ['id' => $id]);
        }
    
        return $this->render('article/add.html.twig', [
            'form' => $form->createView(),
            'edit' => $article->getId(),
        ]);
    }

    #[Route('/article/delete/{id}', name: 'delete_article')]
    public function delete($id,EntityManagerInterface $entityManager): Response
    {
        $article = $entityManager->getRepository(Article::class)->find($id);

        $entityManager->remove($article);
        $entityManager->flush();

        return $this->redirectToRoute('app_home');
    }

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
