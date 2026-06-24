<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

final class Ex06Controller extends AbstractController
{
    #[Route(['/ex06', '/ex06/'], name: 'app_ex06')]
    public function index(Connection $connection): Response {
        $connection->executeStatement("CREATE TABLE IF NOT EXISTS ex06_users (
            id SERIAL PRIMARY KEY,
            username VARCHAR(255) UNIQUE,
            name VARCHAR(255),
            email VARCHAR(255) UNIQUE,
            enable BOOLEAN,
            birthdate TIMESTAMP,
            address TEXT)
        ");
        $users = $connection->fetchAllAssociative("SELECT * FROM ex06_users");
        return $this->render('ex06/index.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route(['/ex06/update/{id}', '/ex06/update/{id}/'], name: 'app_ex06_edit')]
    public function edit(Connection $connection, Request $request, int $id): Response {
        $user = $connection->fetchAssociative("SELECT * FROM ex06_users WHERE id = :id", ['id' => $id]);
        $user['birthdate'] = new \DateTime($user['birthdate']);
        if (!$user) {
            $this->addFlash('failure', 'User not found!');
            return $this->redirectToRoute('app_ex06');
        }
        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            try {
                $connection->executeStatement("UPDATE ex06_users SET 
                username = :username,
                name = :name,
                email = :email,
                enable = :enable,
                birthdate = :birthdate,
                address = :address WHERE id = :id",
                ['username' => $data['username'],
                'name' => $data['name'],
                'email' => $data['email'],
                'enable' => $data['enable'],
                'birthdate' => $data['birthdate']->format('Y-m-d H:i:s'),
                'address' => $data['address'],
                'id' => $id]);
                $this->addFlash('success', 'Item succesfully updated!');
                    return $this->redirectToRoute('app_ex06');
            } catch (\Exception $e) {
                $this->addFlash('failure', 'Failed to update item!');
                    return $this->redirectToRoute('app_ex06');
            }
            
        }
        return $this->render('ex06/edit.html.twig', [
        'form' => $form,
        'user' => $user,
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
