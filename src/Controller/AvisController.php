<?php

namespace App\Controller;

use DateTime;
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
        $count5 = 0;
        $count4 = 0;
        $count3 = 0;
        $count2 = 0;
        $count = 0;

        $article = $entityManager->getRepository(Article::class)->find($id);
        $moyennesNote = $entityManager->getRepository(Article::class)->moyennes();

        foreach($article->getAvis() as $avisCom){
            $avis = $entityManager->getRepository(Avis::class)->find($avisCom->getId());
            if($avis->getNote() == 5){
                $count5++;
            } elseif($avis->getNote() == 4){
                $count4++;
            } elseif($avis->getNote() == 3){
                $count3++;
            } elseif($avis->getNote() == 2){
                $count2++;
            } else{
                $count++;
            }
            
        }

        return $this->render('avis/index.html.twig', [
            'article' => $article,
            'moyennes' =>  $moyennesNote,
            'count' => $count,
            'count2' => $count2,
            'count3' => $count3,
            'count4' => $count4,
            'count5' => $count5,
        ]);
    }
    
    #[Route('/avis/post/{id}', name: 'post_avis')]
    public function posterAvis($id, EntityManagerInterface $entityManager, Request $request): Response
    {
        $note = $request->request->get('note');
        $dateAjd = new DateTime();
        
        
        $article = $entityManager->getRepository(Article::class)->find($id);
        $nb = 0;
        
        foreach($article->getAvis() as $articleAvis){
            $nb += 1;
        }

        $form = $this->createForm(AvisType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $notation = $form->getData();


            $notation->setDatePost($dateAjd);
            $notation->setClient($this->getUser());
            $notation->addArticle($article);
            $notation->setNote($note);
            
            $entityManager->persist($notation);
            $entityManager->flush();

            return $this->redirectToRoute('app_avis', ['id' => $article->getId()]);
        }

        return $this->render('avis/postAvis.html.twig', [
            'form' => $form->createView(),
            'article' => $article,
            'nb' => $nb + 1,
            'edit' => false,
        ]);
    }

    #[Route('/avis/edit/{id}', name: 'edit_avis')]
    public function edit($id, EntityManagerInterface $entityManager, Request $request): Response
    {
        $note = $request->request->get('note');
        $dateAjd = new DateTime();
        
        
        $article = $entityManager->getRepository(Article::class)->find($id);
        $nb = 0;
        
        foreach($article->getAvis() as $articleAvis){
            $nb += 1;
            $avis = $entityManager->getRepository(Avis::class)->find($articleAvis->getId());
        }

        $form = $this->createForm(AvisType::class, $avis);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $notation = $form->getData();

            $notation->setDatePost($dateAjd);
            $notation->setClient($this->getUser());
            $notation->addArticle($article);
            $notation->setNote($note);
            
            $entityManager->persist($notation);
            $entityManager->flush();

            return $this->redirectToRoute('app_avis', ['id' => $article->getId()]);
        }

        return $this->render('avis/postAvis.html.twig', [
            'form' => $form->createView(),
            'article' => $article,
            'edit' => $article->getId()
        ]);
    }

    #[Route('/avis/del/{id}', name: 'app_avis_del')]
    public function del($id, EntityManagerInterface $entityManager): Response
    {
        $avis = $entityManager->getRepository(Avis::class)->find($id);

        foreach($avis->getArticles() as $articles){
           $idArticle = $articles->getId();
        }
        
        $entityManager->remove($avis);
        $entityManager->flush();

        return $this->redirectToRoute('app_avis', ['id' => $idArticle]);
    }
}
