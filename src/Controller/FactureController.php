<?php

namespace App\Controller;

use App\Entity\Facture;
use App\Form\FactureType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FactureController extends AbstractController
{
    #[Route('/facture/add', name: 'add_facture')]
    public function index(EntityManagerInterface $entityManager, Request $request): Response
    {
        $form = $this->createForm(FactureType::class);
        $form->handleRequest($request);

        $facture = new Facture();

        if($form->isSubmitted() && $form->isValid()){
            $facture = $form->getData();

            $facturation = hash('md2' ,'CoffMulhouse');

            $facture->setNumeroDeFacturation($facturation);

            $entityManager->persist($facture);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin');
        }

        return $this->render('facture/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/facture/del', name: 'del_facture')]
    public function del(EntityManagerInterface $entityManager, Request $request): Response
    {
        $factures = $entityManager->getRepository(Facture::class)->findAll();

        $idFacture = $request->request->get('allFacture');
        $btn = $request->request->get('submit'); 

        if($btn === "true"){
            $facture = $entityManager->getRepository(Facture::class)->find($idFacture);

            $entityManager->remove($facture);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin');
        }

        return $this->render('facture/delete.html.twig', [
            'factures' => $factures,
        ]);
    }
}
