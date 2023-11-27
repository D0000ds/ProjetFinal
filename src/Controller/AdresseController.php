<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Adresse;
use App\Form\AdresseType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdresseController extends AbstractController
{
    #[Route('/adresse/{id}/add', name: 'add_adresse')]
    public function add($id, EntityManagerInterface $entityManager, Request $request,): Response
    {
        $form = $this->createForm(AdresseType::class);
        $form->handleRequest($request);
        $user = $entityManager->getRepository(User::class)->find($id);

        $adresse = new Adresse();
        
        if($form->isSubmitted() && $form->isValid()){
            $adresse = $form->getData();
            $adresse->setClient($user);
            $entityManager->persist($adresse);
            $entityManager->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('adresse/index.html.twig', [
            'form' => $form->createView(),
            'edit' => false,
        ]);
    }

    #[Route('/adresse/{id}/edit', name: 'edit_adresse')]
    public function edit($id, EntityManagerInterface $entityManager, Request $request,): Response
    {
        $adresse = $entityManager->getRepository(Adresse::class)->find($id);

        $form = $this->createForm(AdresseType::class, $adresse);
        $form->handleRequest($request);

        
        if($form->isSubmitted() && $form->isValid()){
            $adresse = $form->getData();
            $entityManager->persist($adresse);
            $entityManager->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('adresse/index.html.twig', [
            'form' => $form->createView(),
            'edit' => $adresse->getId(),
            'adresse' => $adresse,
        ]);
    }

    #[Route('/adresse/{id}/delete', name: 'del_adresse')]
    public function delete($id, EntityManagerInterface $entityManager, Request $request,): Response
    {
        $adresse = $entityManager->getRepository(Adresse::class)->find($id);
        $client = $entityManager->getRepository(User::class)->find(7);

        $adresse->setClient($client);

        $entityManager->persist($adresse);
        $entityManager->flush();

        return $this->redirectToRoute('app_home');
    }
}
