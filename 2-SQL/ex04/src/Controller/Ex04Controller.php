<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use Doctrine\DBAL\Connection;

final class Ex04Controller extends AbstractController
{
    #[Route(['/ex04/', '/ex04'], name: 'app_ex04')]
    public function index(Connection $connection): Response
    {
        $connection->executeStatement("CREATE TABLE IF NOT EXISTS ex04_users (
            id SERIAL PRIMARY KEY,
            username VARCHAR(255) UNIQUE,
            name VARCHAR(255),
            email VARCHAR(255) UNIQUE,
            enable BOOLEAN,
            birthdate TIMESTAMP,
            address TEXT)
        ");
        $users = $connection->fetchAllAssociative("SELECT * FROM ex04_users");
        return $this->render('ex04/index.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route(['/ex04/delete/{id}/', '/ex04/delete/{id}'], name: 'app_ex04_delete')]
    public function delete(Connection $connection, int $id): Response {
        $user = $connection->fetchAssociative(
            "SELECT * FROM ex04_users WHERE id = :id",
            ['id' => $id]
        );
        if (!$user) {
            $this->addFlash('failure', 'User not found!');
            return $this->redirectToRoute('app_ex04');
        }
        try {
            $connection->executeStatement("DELETE FROM ex04_users WHERE id = :id", ['id' => $id]);
            $this->addFlash('success', 'Item succesfully deleted!');
            return $this->redirectToRoute('app_ex04');
        } catch (\Exception $e) {
            $this->addFlash('failure', 'Failed to delete item!');
            return $this->redirectToRoute('app_ex04');
        }
    }
}
