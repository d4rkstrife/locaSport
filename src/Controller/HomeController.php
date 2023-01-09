<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    public function __construct(private ArticleRepository $articleRepository){

    }
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $articles = $this->articleRepository->findAll();
        return $this->render('home/index.html.twig', ['articles'=>$articles]);
    }

    #[Route('/article/{id}', name: 'app_home_details')]
    public function articleDetails(Article $article): Response
    {
        return $this->render('home/details.html.twig', ['article'=>$article]);
    }
}
