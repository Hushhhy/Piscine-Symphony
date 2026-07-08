<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\DBAL\Connection;

final class Ex08Controller extends AbstractController
{
    #[Route(['/ex08', '/ex08/'], name: 'app_ex08')]
    public function index(Connection $connection): Response {
        $persons_columns = $connection->fetchAllAssociative("
        SELECT column_name, data_type 
        FROM information_schema.columns 
        WHERE table_name = 'persons'
        ");

        $bank_columns = $connection->fetchAllAssociative("
            SELECT column_name, data_type 
            FROM information_schema.columns 
            WHERE table_name = 'bank_accounts'
            ORDER BY ordinal_position
        ");

        $addresses_columns = $connection->fetchAllAssociative("
            SELECT column_name, data_type 
            FROM information_schema.columns 
            WHERE table_name = 'addresses'
            ORDER BY ordinal_position
        ");

        return $this->render('ex08/index.html.twig', [
            'persons_columns' => $persons_columns,
            'bank_columns' => $bank_columns,
            'addresses_columns' => $addresses_columns,
        ]);
    }

    #[Route(['/ex08/create', '/ex08/create/'], name: 'app_ex08_create')]
    public function create(Connection $connection): Response {
        try {
            $connection->executeStatement("CREATE TABLE IF NOT EXISTS persons (
            id SERIAL PRIMARY KEY,
            username VARCHAR(255) UNIQUE,
            name VARCHAR(255),
            email VARCHAR(255) UNIQUE,
            enable BOOLEAN,
            birthdate TIMESTAMP)
            ");
            $this->addFlash('success', 'Table created successfully!');
            return $this->redirectToRoute('app_ex08');
        } catch (\Exception $e) {
            $this->addFlash('failure', 'Failed to create table!');
            return $this->redirectToRoute('app_ex08');
        }
    }

    #[Route(['/ex08/addColumn', '/ex08/addColumn/'], name: 'app_ex08_addColumn')]
    public function addColumn(Connection $connection): Response {
        try {
            $connection->executeStatement("CREATE TYPE marital_status_type AS ENUM ('single', 'married', 'widower')");
            $connection->executeStatement("ALTER TABLE persons ADD COLUMN marital_status marital_status_type");
            $this->addFlash('success', 'Succesfully added 1 column!');
            return $this->redirectToRoute('app_ex08');
        } catch (\Exception $e) {
            $this->addFlash('failure', 'Failed to add 1 column!');
            return $this->redirectToRoute('app_ex08');
        }
    }

    #[Route(['/ex08/otherTables', '/ex08/otherTables/'], name: 'app_ex08_otherTables')]
    public function otherTables(Connection $connection): Response {
        try {
            $connection->executeStatement("CREATE TABLE bank_accounts (
            id SERIAL PRIMARY KEY,
            iban VARCHAR(255),
            person_id INT UNIQUE,
            FOREIGN KEY (person_id) REFERENCES persons(id))");
            
            $connection->executeStatement("CREATE TABLE addresses (
            id SERIAL PRIMARY KEY,
            street VARCHAR(255),
            city VARCHAR(255))");

            $connection->executeStatement("ALTER TABLE persons ADD COLUMN address_id INT");
            $connection->executeStatement("ALTER TABLE persons ADD FOREIGN KEY (address_id) REFERENCES addresses(id)");
            $this->addFlash('success', 'Succesfully created Bank_accounts and addresses tables!');
            return $this->redirectToRoute('app_ex08');
        } catch (\Exception $e) {
            $this->addFlash('failure', 'Failed to create bank_accounts and addresses tables!');
            return $this->redirectToRoute('app_ex08');
        }
    }
}
