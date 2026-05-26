<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\DBAL\Connection;

final class Ex00Controller extends AbstractController
{
    #[Route(['/ex00', '/ex00/'], name: 'app_ex00')]
    public function index(): Response {
        return $this->render('ex00/index.html.twig');
    }

    #[Route(['/ex00/create', '/ex00/create/'], name:'app_ex00_create')]
    public function create(Connection $connection): Response {
        try {
            $connection->executeStatement("CREATE TABLE IF NOT EXISTS ex00_users (
                id SERIAL PRIMARY KEY,
                username VARCHAR(255) UNIQUE,
                name VARCHAR(255),
                email VARCHAR(255) UNIQUE,
                enable BOOLEAN,
                birthdate TIMESTAMP,
                address TEXT)
            ");
            $this->addFlash('success', 'Table created successfully!');
            return $this->redirectToRoute('app_ex00');
        } catch (\Exception $e) {
            $this->addFlash('failure', 'Failed to create table!');
            return $this->redirectToRoute('app_ex00');
        }
    }
}
