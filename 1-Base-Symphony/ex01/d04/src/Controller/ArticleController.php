<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ArticleController extends AbstractController
{
    private const ARTICLES = ['gull', 'cat', 'dog'];

    #[Route('/e01', name: 'main')]
    public function main(): Response
    {
        return $this->render('main.html.twig', [
            'articles' => self::ARTICLES,
        ]);
    }

    #[Route('/e01/{article}', name: 'article')]
    public function article(string $article): Response
    {
        if (!in_array($article, self::ARTICLES, true)) {
            return $this->render('main.html.twig', [
                'articles' => self::ARTICLES,
            ]);
        }

        return $this->render($article . '.html.twig');
    }
}