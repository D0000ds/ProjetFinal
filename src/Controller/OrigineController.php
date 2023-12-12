<?php

namespace App\Controller;

use App\Entity\Origine;
use App\Form\OrigineType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrigineController extends AbstractController
{
    #[Route('/origine/add', name: 'add_origine')]
    public function add(EntityManagerInterface $entityManager, Request $request): Response
    {
        $form = $this->createForm(OrigineType::class);
        $form->handleRequest($request);

        $origine = new Origine();

        if($form->isSubmitted() && $form->isValid()){
            $origine = $form->getData();
            $entityManager->persist($origine);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin');
        }

        return $this->render('origine/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/origine/del', name: 'del_origine')]
    public function del(EntityManagerInterface $entityManager, Request $request): Response
    {
        $origines = $entityManager->getRepository(Origine::class)->findAll();

        $idOrigine = $request->request->get('allOrigine');
        $btn = $request->request->get('submit'); 

        if($btn === "true"){
            $origine = $entityManager->getRepository(Origine::class)->find($idOrigine);

            $entityManager->remove($origine);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin');
        }

        return $this->render('origine/delete.html.twig', [
            'origines' => $origines,
        ]);
    }
}
