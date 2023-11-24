<?php

namespace App\Controller;

use DateTime;
use Stripe\Stripe;
use Stripe\Customer;
use App\Entity\Adresse;
use App\Entity\Article;
use App\Entity\Facture;
use App\Entity\Commande;
use Stripe\Checkout\Session;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PayementController extends AbstractController
{
    #[Route('/payement', name: 'app_payement')]
    public function index(SessionInterface $session, Request $request, EntityManagerInterface $entityManager): Response
    {
        $lineItems= [];
        $quantiteTotal = 0;
        $panier = $session->get('panier', []);
        $livraison = $request->request->get('livraison');
        $adresseId= $request->request->get('adresse');

        $adresse = $entityManager->getRepository(Adresse::class)->find($adresseId);

        
        foreach($panier as $id => $quantite){
            $article = $entityManager->getRepository(Article::class)->find($id);
            $data[] = [
                'article' => $article,
                'quantite' => $quantite
            ];

            $quantiteTotal += $quantite;
        }

        if($livraison == "clickAndCollect"){
            $total = 0;
        } else {
            $total = 10 / $quantiteTotal;
        }


        foreach($data as $produit){
            $lineItems[] = [
                'quantity' => $produit['quantite'],
                'price_data' => [
                    'currency' => 'EUR',
                    'product_data' => [
                        'name' => $produit['article']->getLibelle(),
                    ],
                    'unit_amount' => ($produit['article']->getPrix()) * 100, 
                ],
            ];
        }
        
        Stripe::setApiKey($_ENV["STRIPE_SECRET"]);
        Stripe::setApiVersion('2023-10-16');
        
        $session = Session::create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'customer_email' => $adresse->getClient()->getEmail(),
            'success_url' => 'http://127.0.0.1:8000/payement/sucess/'.$adresseId,
            'cancel_url' => 'http://127.0.0.1:8000/home',
            'payment_intent_data' => [
                'shipping' => [
                  'name' => $adresse->getClient()->getNom() .' '. $adresse->getClient()->getNom(),
                  'phone' => $adresse->getClient()->getTelephone(),
                  'address' => [
                    'country' => 'France',
                    'city' => $adresse->getVille(),
                    'line1' => $adresse->getAdresse(),
                    'postal_code' => $adresse->getCodePostal()
                  ],
                ],
            ],
        ]);

        return $this->redirect($session->url);
    }

    #[Route('/payement/sucess/{id}', name: 'app_payement_sucess')]
    public function sucess($id, EntityManagerInterface $entityManager, SessionInterface $session): Response
    {
        $adresse = $entityManager->getRepository(Adresse::class)->find($id);
        $panier = $session->get('panier', []);

        $facture = new Facture();
        $commande = new Commande();
        $quantiteTotal = 0;
        $facturation = hash('md2' ,'CoffMulhouse'. $adresse->getClient()->getId()."".$adresse->getId());
        $date = new DateTime();


        foreach($panier as $id => $quantite){
            $article = $entityManager->getRepository(Article::class)->find($id);
            $data[] = [
                'article' => $article,
                'quantite' => $quantite
            ];

            $quantiteTotal += $quantite;
        }

        foreach($data as $produit){
            $facture->setPrix($quantiteTotal * $produit['article']->getPrix());
            $facture->setLibelleArticle($produit['article']->getLibelle());
        }
        
        $facture->setNomClient($adresse->getClient()->getNom());
        $facture->setPrenomClient($adresse->getClient()->getPrenom());
        $facture->setAdresseFacturation($adresse->getAdresse());
        $facture->setQteArticle($quantiteTotal);
        $facture->setNumeroDeFacturation($facturation);
        $facture->setDateCommande($date);
        
        $commande->setDateCommande($date);
        $commande->setAdresse($adresse);
        $commande->setFacture($facture);
        $commande->setClient($adresse->getClient());
        $commande->addCommandeArticle();



        $entityManager->persist($facture);
        $entityManager->flush();


         $session->remove('panier');

        return $this->render('payement/sucess.html.twig');
    }
}
