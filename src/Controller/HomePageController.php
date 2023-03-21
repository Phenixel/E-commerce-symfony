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
}
