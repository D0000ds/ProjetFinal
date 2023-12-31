<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Service\PictureService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategorieController extends AbstractController
{

    #[Route('/categorie/add', name: 'add_categories')]
    public function add(EntityManagerInterface $entityManager,  Request $request, PictureService $pictureService): Response
    {
        $form = $this->createForm(CategorieType::class);
        $form->handleRequest($request);

        $categorie = new Categorie();

        if($form->isSubmitted() && $form->isValid()){
            $image = $form->get('image')->getData();
            
            $fichier = $pictureService->add($image);

            $categorie = $form->getData();
            $categorie->setImage("Img/" . $fichier);
            $entityManager->persist($categorie);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin');
        }

        return $this->render('categorie/add.html.twig', [
            'form' => $form->createView(),
            'edit' => false,
        ]);
    }

    #[Route('/categorie/edit/{id}', name: 'edit_categories')]
    public function edit($id,EntityManagerInterface $entityManager,  Request $request, PictureService $pictureService): Response
    {
        $categorie = $entityManager->getRepository(Categorie::class)->find($id);

        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){
            $image = $form->get('image')->getData();
            
            $fichier = $pictureService->add($image);

            $categorie = $form->getData();
            $categorie->setImage("Img/" . $fichier);
            $entityManager->persist($categorie);
            $entityManager->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('categorie/add.html.twig', [
            'form' => $form->createView(),
            'edit' => $categorie->getId(),
        ]);
    }

    #[Route('/categorie/delete/{id}', name: 'delete_categories')]
    public function delete($id,EntityManagerInterface $entityManager): Response
    {
        $categorie = $entityManager->getRepository(Categorie::class)->find($id);

        $entityManager->remove($categorie);
        $entityManager->flush();

        return $this->redirectToRoute('app_home');
    }

    #[Route('/categorie/cafees moulues', name: 'app_categorie_cafees_moulues')]
    public function indexCafeesMoulues(EntityManagerInterface $entityManager): Response
    {
        $categories = $entityManager->getRepository(Categorie::class)->findBy(['code' => 'CAFÉES MOULUES']);
        $nbArticleCategories = $entityManager->getRepository(Categorie::class)->nbArticleParCategorie();

        return $this->render('categorie/indexCafeesMoulues.html.twig', [
            'categories' => $categories,
            'nbArticleCategories' => $nbArticleCategories,
        ]);
    }

    #[Route('/categorie/cafes en grains', name: 'app_categorie_cafes_grains')]
    public function indexCafesEnGrains(EntityManagerInterface $entityManager): Response
    {
        $categories = $entityManager->getRepository(Categorie::class)->findBy(['code' => 'CAFÉS EN GRAINS']);
        $nbArticleCategories = $entityManager->getRepository(Categorie::class)->nbArticleParCategorie();

        return $this->render('categorie/indexCafesEnGrains.html.twig', [
            'categories' => $categories,
            'nbArticleCategories' => $nbArticleCategories,
        ]);
    }

    #[Route('/categorie/cafes dossetes', name: 'app_categorie_cafes_dossetes')]
    public function indexCafesDossetes(EntityManagerInterface $entityManager): Response
    {
        $categories = $entityManager->getRepository(Categorie::class)->findBy(['code' => 'CAFÉS DOSSETES']);
        $nbArticleCategories = $entityManager->getRepository(Categorie::class)->nbArticleParCategorie();
    
        return $this->render('categorie/indexCafesDossetes.html.twig', [
            'categories' => $categories,
            'nbArticleCategories' => $nbArticleCategories,
        ]);
    }

    #[Route('/categorie/cafes capsules', name: 'app_categorie_cafes_capsules')]
    public function indexCafesCapsules(EntityManagerInterface $entityManager): Response
    {
        $categories = $entityManager->getRepository(Categorie::class)->findBy(['code' => 'CAFÉS CAPSULES']);
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

    #[Route('/categorie/cafes dossetes/{id}', name: 'detail_categorie_cafes_dossetes')]
    public function detailCafesDossetes($id, EntityManagerInterface $entityManager)
    {
        $categorie = $entityManager->getRepository(Categorie::class)->find($id);
        $moyennesNote = $entityManager->getRepository(Article::class)->moyennes();

        return $this->render('categorie/detailCafesDossetes.html.twig', [
            'categorie' => $categorie,
            'moyennes' =>  $moyennesNote,
        ]);
    }

    #[Route('/categorie/cafes en grains/{id}', name: 'detail_categorie_cafes_grains')]
    public function detailCafesCafesEnGrains($id, EntityManagerInterface $entityManager)
    {
        $categorie = $entityManager->getRepository(Categorie::class)->find($id);
        $moyennesNote = $entityManager->getRepository(Article::class)->moyennes();

        return $this->render('categorie/detailCafesEnGrains.html.twig', [
            'categorie' => $categorie,
            'moyennes' =>  $moyennesNote,
        ]);
    }

    #[Route('/categorie/cafes moulues/{id}', name: 'detail_categorie_cafes_moulues')]
    public function detailCafesCafesMoulues($id, EntityManagerInterface $entityManager)
    {
        $categorie = $entityManager->getRepository(Categorie::class)->find($id);
        $moyennesNote = $entityManager->getRepository(Article::class)->moyennes();

        return $this->render('categorie/detailCafesMoulues.html.twig', [
            'categorie' => $categorie,
            'moyennes' =>  $moyennesNote,
        ]);
    }
}
