<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(SessionInterface $session, ArticleRepository $articleRepository): Response
    {
        $panier = $session->get("panier", []);

        $dataPanier = [];
        $total = 0;

        foreach ($panier as $id => $quantite) {
            $article = $articleRepository->find($id);
            $dataPanier[] = [
                "article" => $article,
                "quantite" => $quantite
            ];
            $total += $article->getPrix() * $quantite;
        }

        return $this->render('cart/index.html.twig', compact("dataPanier", "total"));
    }

    #[Route('/checkout', name: 'app_cart_checkout')]
    public function checkout(SessionInterface $session, ArticleRepository $articleRepository): Response
    {
        $panier = $session->get("panier", []);

        $dataPanier = [];
        $total = 0;

        foreach ($panier as $id => $quantite) {
            $article = $articleRepository->find($id);
            $dataPanier[] = [
                "article" => $article,
                "quantite" => $quantite
            ];
            $total += $article->getPrix() * $quantite;
        }

        return $this->render('cart/checkout.html.twig', compact("dataPanier", "total"));
    }

    #[Route('/cart/add/{id}', name: 'app_cart_add')]
    public function add(Article $article, SessionInterface $session): Response
    {
//        on récupère le panier
        $panier = $session->get("panier", []);
        $id = $article->getId();

        if (!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }

//        Sauvegarde
        $session->set("panier", $panier);

        return $this->redirectToRoute("app_cart");
    }

    #[Route('/cart/remove/{id}', name: 'app_cart_remove')]
    public function remove(Article $article, SessionInterface $session): Response
    {
//        on récupère le panier
        $panier = $session->get("panier", []);
        $id = $article->getId();

        if (!empty($panier[$id])) {
            if ($panier[$id] > 1) {
                $panier[$id]--;
            } else {
                unset($panier[$id]);
            }
        }

//        Sauvegarde
        $session->set("panier", $panier);

        return $this->redirectToRoute("app_cart");
    }

    #[Route('/cart/delete/{id}', name: 'app_cart_delete')]
    public function delete(Article $article, SessionInterface $session): Response
    {
//        on récupère le panier
        $panier = $session->get("panier", []);
        $id = $article->getId();

        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }

//        Sauvegarde
        $session->set("panier", $panier);

        return $this->redirectToRoute("app_cart");
    }

}