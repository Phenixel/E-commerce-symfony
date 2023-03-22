<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends AbstractController
{
    #[Route('/home/page', name: 'app_home_page')]
    public function index(ArticleRepository $articleRepository, CategorieRepository $categorieRepository): Response
    {
        return $this->render('home_page/index.html.twig', [
            'controller_name' => 'HomePageController',
            'articles' => $articleRepository->findAll(),
            'categories' => $categorieRepository->findAll(),
        ]);
    }

    #[Route('/a-propos', name: 'page_about')]
    public function apropos(): Response
    {
        return $this->render('home_page/apropos.html.twig', [

        ]);
    }

    #[Route('/cgv', name: 'page_cgv')]
    public function cgv(): Response
    {
        return $this->render('home_page/cgv.html.twig', [

        ]);
    }

    #[Route('/cgu', name: 'page_cgu')]
    public function cgu(): Response
    {
        return $this->render('home_page/cgu.html.twig', [

        ]);
    }

    #[Route('/back_office', name: 'app_back_office', methods: ['GET'])]
    public function backoffice(ArticleRepository $articleRepository, CategorieRepository $categorieRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('home_page/back_office.html.twig', [
            'articles' => $articleRepository->findAll(),
            'categories' => $categorieRepository->findAll(),
        ]);
    }
}
