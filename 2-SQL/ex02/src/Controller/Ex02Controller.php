<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\DBAL\Connection;

final class Ex02Controller extends AbstractController
{
    #[Route(['/ex02', '/ex02/'], name: 'app_ex02')]
    public function index(Request $request, Connection $connection): Response
    {
        $connection->executeStatement("CREATE TABLE IF NOT EXISTS ex02_users (
            id SERIAL PRIMARY KEY,
            username VARCHAR(255) UNIQUE,
            name VARCHAR(255),
            email VARCHAR(255) UNIQUE,
            enable BOOLEAN,
            birthdate TIMESTAMP,
            address TEXT)
        ");
        $form = $this->createForm(UserFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            try {
                $connection->executeStatement(
                    "INSERT INTO ex02_users (
                        username, name, email, enable, birthdate, address) 
                    VALUES (:username, :name, :email, :enable, :birthdate, :address)", 
                    ['username' => $data['username'], 
                    'name' => $data['name'], 
                    'email' => $data['email'], 
                    'enable' => $data['enable'], 
                    'birthdate' => $data['birthdate']->format('Y-m-d H:i:s'), 
                    'address' => $data['address']]
                );
                $this->addFlash('success', 'Table created successfully!');
                return $this->redirectToRoute('app_ex02');
            } catch (\Exception $e) {
                $this->addFlash('failure', 'Failed to create table!');
                return $this->redirectToRoute('app_ex02');
            }
        }
        $users = $connection->fetchAllAssociative("SELECT * FROM ex02_users");
        return $this->render('ex02/index.html.twig', [
            'form' => $form,
            'users' => $users,
        ]);
    }
}

final class UserFormType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder 
            ->add('username', TextType::class)
            ->add('name', TextType::class)
            ->add('email', EmailType::class)
            ->add('birthdate', DateTimeType::class)
            ->add('address', TextareaType::class)
            ->add('enable', CheckboxType::class)
            ->add('submit', SubmitType::class);
    }
}
