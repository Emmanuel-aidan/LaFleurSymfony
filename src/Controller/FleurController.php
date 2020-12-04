<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Fleurs;
use App\Repository\CategorieRepository;
use App\Repository\FleurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FleurController extends AbstractController
{
    /**
     * @Route("/fleurs", name="index_catalogue")
     */
    public function index(FleurRepository $fleurRepo, CategorieRepository $categRepo): Response
    {
        $lesFleurs = $fleurRepo->findAll();
        $lesCategories = $categRepo->findAll();

        return $this->render('fleur/index.html.twig', [
            'lesFleurs' => $lesFleurs,
            'lesCategories' => $lesCategories,
        ]);
    }

    /**
     * @Route("/fleurs/{id}", name="cat_fleurs")
     */
    public function fleurcat($id, FleurRepository $fleurRepo, CategorieRepository $categRepo): Response
    {
        $lesFleurs = $fleurRepo->findBy(['uneCategorie' => $id]);
        $lesCategories = $categRepo->findAll();

        return $this->render('fleur/index.html.twig', [
            'lesFleurs' => $lesFleurs,
            'lesCategories' => $lesCategories,
        ]);
    }
}
