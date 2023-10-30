<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Categorie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategorieController extends AbstractController
{
    #[Route('/categorie/cafees moulues', name: 'app_categorie_cafees_moulues')]
    public function indexCafeesMoulues(EntityManagerInterface $entityManager): Response
    {
        $categories = $entityManager->getRepository(Categorie::class)->findBy(['code' => 'CM']);
        $nbArticleCategories = $entityManager->getRepository(Categorie::class)->nbArticleParCategorie();

        return $this->render('categorie/indexCafeesMoulues.html.twig', [
            'categories' => $categories,
            'nbArticleCategories' => $nbArticleCategories,
        ]);
    }

    #[Route('/categorie/cafes en grains', name: 'app_categorie_cafes_grains')]
    public function indexCafesEnGrains(EntityManagerInterface $entityManager): Response
    {
        $categories = $entityManager->getRepository(Categorie::class)->findBy(['code' => 'CG']);
        $nbArticleCategories = $entityManager->getRepository(Categorie::class)->nbArticleParCategorie();

        return $this->render('categorie/indexCafesEnGrains.html.twig', [
            'categories' => $categories,
            'nbArticleCategories' => $nbArticleCategories,
        ]);
    }

    #[Route('/categorie/cafes dossetes', name: 'app_categorie_cafes_dossetes')]
    public function indexCafesDossetes(EntityManagerInterface $entityManager): Response
    {
        $categories = $entityManager->getRepository(Categorie::class)->findBy(['code' => 'CD']);
        $nbArticleCategories = $entityManager->getRepository(Categorie::class)->nbArticleParCategorie();
    
        return $this->render('categorie/indexCafesDossetes.html.twig', [
            'categories' => $categories,
            'nbArticleCategories' => $nbArticleCategories,
        ]);
    }

    #[Route('/categorie/cafes capsules', name: 'app_categorie_cafes_capsules')]
    public function indexCafesCapsules(EntityManagerInterface $entityManager): Response
    {
        $categories = $entityManager->getRepository(Categorie::class)->findBy(['code' => 'CC']);
        $nbArticleCategories = $entityManager->getRepository(Categorie::class)->nbArticleParCategorie();
            
       

        return $this->render('categorie/indexCafesCapsules.html.twig', [
            'categories' => $categories,
            'nbArticleCategories' => $nbArticleCategories,
        ]);
    }

    #[Route('/categorie/cafes capsules/{id}', name: 'detail_categorie_cafes_capsules')]
    public function detailCafesCapsules($id, EntityManagerInterface $entityManager)
    {
        $categorie = $entityManager->getRepository(Categorie::class)->find($id);
        $moyennesNote = $entityManager->getRepository(Article::class)->moyennes();

        return $this->render('categorie/detailCafesCapsules.html.twig', [
            'categorie' => $categorie,
            'moyennes' =>  $moyennesNote,
        ]);
    }
}
