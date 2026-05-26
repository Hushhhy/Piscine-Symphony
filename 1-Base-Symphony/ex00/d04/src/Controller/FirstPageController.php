<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FirstPageController
{
    #[Route('/e00/firstpage')]
    public function index(): Response
    {
        return new Response('Hello world!');
    }
}