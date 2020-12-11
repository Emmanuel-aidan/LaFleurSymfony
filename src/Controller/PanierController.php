<?php

namespace App\Controller;

use App\Repository\FleurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    /**
     * @Route("/panier", name="index_panier")
     */
    public function index(SessionInterface $session, FleurRepository $fleurrepo): Response
    {
        $panier = $session->get('panier', []);
        $panierAvecDonnees = [];

        foreach($panier as $id => $quantite)
        {
            $panierAvecDonnees[] = [
                'fleur' =>$fleurrepo->find($id),
                'qte' =>$quantite
            ];
        }
        //dd($panierAvecDonnees);



        return $this->render('panier/index.html.twig', [
            'lesfleurs' => $panierAvecDonnees,
        ]);
    }

    /**
     * @Route("/panier/add/{id}", name="add_panier")
     */
    public function add($id, SessionInterface $session): Response
    {
       $panier = $session->get('panier', []);
       if (!empty($panier[$id])) 
       {
           $panier[$id] ++;
       }
       else
       {
           $panier[$id] = 1;
       }
       $session->set('panier', $panier);
       $this->addFlash('panier', "Le produit a été ajouté au panier");
       //dd($panier);

       return $this->redirectToRoute("index_catalogue");
    }

    public function nbProdPanier(SessionInterface $session)
    {
        $panier = $session->get('panier',[]);
        $total = 0;
        foreach($panier as $id => $quantite)
        {
            $total = $total + $quantite;
        }
        return $this->render('panier/nbProdPanier.html.twig', ['nb' => $total]);
    }


     /**
     * @Route("/panier/plus/{id}", name="panier_plus")
     */
    public function plus($id, SessionInterface $session) : Response
    {
       $panier = $session->get('panier', []);
       if (!empty($panier[$id])) 
       {
           $panier[$id] ++;
       }
       $session->set('panier', $panier);
       $this->addFlash('panier', "Le produit a été ajouté au panier");
       //dd($panier);
       return $this->redirectToRoute("panier");
    }
    
     /**
     * @Route("/panier/moins/{id}", name="panier_moins")
     */
    public function moins($id, SessionInterface $session) : Response
    {
       $panier = $session->get('panier', []);
       if (!empty($panier[$id])) 
       {
           $panier[$id] --;
           if($panier[$id]==0)
            {
                unset($panier[$id]);
            }
       }
       $session->set('panier', $panier);
       $this->addFlash('panier', "Le produit a été ajouté au panier");
       //dd($panier);
       return $this->redirectToRoute("panier");
    }

     

     /**
     * @Route("/panier/remove/{id}", name="panier_remove")
     */
    public function remove($id, SessionInterface $session) : Response
    {

        $panier = $session->get('panier', []);
        if (!empty($panier[$id])) 
        {
            $panier[$id] ++;
        }
        else
        {
            $panier[$id] = 1;
        }
        $session->set('panier', $panier);
        $this->addFlash('panier', "Le produit a été supprimé");
        //dd($panier);
 
        return $this->redirectToRoute("panier");
      
    }
}
