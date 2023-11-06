<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(SessionInterface $session, EntityManagerInterface $entityManager): Response
    {
        $panier = $session->get('panier', []);

        // on initialise des variables
        $data = [];
        $total = 0;

        foreach($panier as $id => $quantite){
           $article = $entityManager->getRepository(Article::class)->find($id);
           $data[] = [
            'article' => $article,
            'quantite' => $quantite
           ];
           $total += $article->getPrix() * $quantite;
        }
        // $lastData = end($data);


        return $this->render('cart/index.html.twig', [
            'data' => $data,
            'total' => $total,
            // 'lastData' => $lastData,
        ]);
    }

    #[Route('/add/{id}', name: 'add_cart')]
    public function add($id, SessionInterface $session, Request $request): Response
    {
        // on recupère le panier existant
        $panier = $session->get('panier', []);

        $qte = $request->request->get('selectQte');

        // on ajoute le produit dans le panier sinon on l'incremente
        if($qte != null){
            if(empty($panier[$id])){
                $panier[$id] = $qte;
            }else {
                $panier[$id] = $panier[$id] + $qte;
            }
        }else {
            if(empty($panier[$id])){
                $panier[$id] = 1;
            }else {
                $panier[$id]++;
            }
        }

        $session->set('panier', $panier);

        $route = $request->headers->get('referer');

        return $this->redirect($route);
    }

    #[Route('/remove/{id}', name: 'remove_cart')]
    public function remove($id, SessionInterface $session,Request $request): Response
    {
        // on recupère le panier existant
        $panier = $session->get('panier', []);

        // on ajoute le produit dans le panier sinon on décrémente
        if(!empty($panier[$id])){
            if($panier[$id] > 0){
                $panier[$id]--;
            }
        }else {
            unset($panier[$id]);
        }

        $session->set('panier', $panier);

        $route = $request->headers->get('referer');

        return $this->redirect($route);
    }

    #[Route('/delete/{id}', name: 'delete_cart')]
    public function delete($id, SessionInterface $session, Request $request): Response
    {
        // on recupère le panier existant
        $panier = $session->get('panier', []);

        // on ajoute le produit dans le panier sinon on décrémente
        if(!empty($panier[$id])){
            unset($panier[$id]);
        }

        $session->set('panier', $panier);

        $route = $request->headers->get('referer');

        return $this->redirect($route);
    }

    #[Route('/empty', name: 'empty_cart')]
    public function empty(SessionInterface $session, Request $request): Response
    {
        $session->remove('panier');
        $route = $request->headers->get('referer');

        return $this->redirect($route);
    }
}
