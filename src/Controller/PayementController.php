<?php

namespace App\Controller;

use DateTime;
use Dompdf\Dompdf;
use Stripe\Stripe;
use Stripe\Customer;
use App\Entity\Adresse;
use App\Entity\Article;
use App\Entity\Facture;
use App\Entity\Commande;
use Stripe\Checkout\Session;
use App\Entity\CommandeArticle;
use Symfony\Component\Mime\Email;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PayementController extends AbstractController
{

    #[Route('/sendMail', name: 'app_mail')]
    public function sendMail(MailerInterface $mailer): Response
    {
        $dompdf = new Dompdf();
        $dompdf->loadHtml('hello world');

        $dompdf->render();
        

        $email = (new Email())
            ->from('achat@coffmulhouse.fr')
            ->to($this->getUser()->getEmail())
            ->subject('Achat sur CoffMulhouse')
            ->text('Merci pour votre Achat voila votre facture')
            ->attachFromPath(new DataPart(new File('../public/Img/Commandes_Symfony.pdf')));

        $mailer->send($email);


        return $this->render('payement/sucess.html.twig');
    }

    #[Route('/payement', name: 'app_payement')]
    public function index(SessionInterface $session, Request $request, EntityManagerInterface $entityManager): Response
    {
        $lineItems= [];
        $quantiteTotal = 0;
        $panier = $session->get('panier', []);
        $livraison = $request->request->get('livraison');
        $adresseId= $request->request->get('adresse');
        $retenir = $request->request->get('retenir');
        $clickandcollect = $session->set('clickandcollect', $livraison);

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
            $total = 10;
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
            'shipping_options' => [
                [
                  'shipping_rate_data' => [
                    'type' => 'fixed_amount',
                    'fixed_amount' => [
                      'amount' => 10 * 100,
                      'currency' => 'eur',
                        ],
                    'display_name' => 'Livraison standard',
                    ],
                ],
            ],
        ]);

        if($retenir == "true"){
            $user = $this->getUser();
            $nom = $request->request->get('nom');
            $prenom = $request->request->get('prenom');
            $tel = $request->request->get('tel');

            

            $user->setPrenom($nom);
            $user->setNom($prenom);
            $user->setTelephone($tel);

            $entityManager->persist($user);
        
            $entityManager->flush();
        }

        return $this->redirect($session->url);
    }

    #[Route('/payement/sucess/{id}', name: 'app_payement_sucess')]
    public function sucess($id, EntityManagerInterface $entityManager, SessionInterface $session): Response
    {
        $adresse = $entityManager->getRepository(Adresse::class)->find($id);
        $adresseCoffee = $entityManager->getRepository(Adresse::class)->find(3);
        $panier = $session->get('panier', []);

        $facture = new Facture();
        $commande = new Commande();
        $commandeArticle = new CommandeArticle();
        $quantiteTotal = 0;
        $facturation = hash('md2' ,'CoffMulhouse'. $adresse->getClient()->getId()."".$adresse->getId());
        $date = new DateTime();
        $clickandcollect = $session->get('clickandcollect');
        


        foreach($panier as $id => $quantite){
            $article = $entityManager->getRepository(Article::class)->find($id);
            $data[] = [
                'article' => $article,
                'quantite' => $quantite
            ];

            $quantiteTotal += $quantite;
        }

        foreach($data as $produit){
            if($clickandcollect == "clickAndCollect"){
                $facture->setPrix($quantiteTotal * $produit['article']->getPrix());
            } else{
                $facture->setPrix($quantiteTotal * $produit['article']->getPrix() + 10);
            }
            $facture->setLibelleArticle($produit['article']->getLibelle());

            $commandeArticle->setArticle($produit['article']);
        }

        
        $facture->setNomClient($adresse->getClient()->getNom());
        $facture->setPrenomClient($adresse->getClient()->getPrenom());
        $facture->setAdresseFacturation($adresse->getAdresse());
        $facture->setQteArticle($quantiteTotal);
        $facture->setNumeroDeFacturation($facturation);
        $facture->setDateCommande($date);
        
        $commande->setDateCommande($date);
        $commande->setFacture($facture);
        $commande->setClient($adresse->getClient());

        if($clickandcollect == "clickAndCollect"){
            $commande->setClickAndCollect(true);
            $commande->setAdresse($adresseCoffee);
        } else{
            $commande->setClickAndCollect(false);
            $commande->setAdresse($adresse);
        }
        
        $commandeArticle->setQuantite($quantite);
        $commandeArticle->setCommande($commande);



        $entityManager->persist($facture);
        $entityManager->persist($commande);
        $entityManager->persist($commandeArticle);
        
        $entityManager->flush();


        $session->remove('panier');

        return $this->redirectToRoute('app_mail');
    }

}
