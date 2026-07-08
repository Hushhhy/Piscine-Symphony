<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

final class Ex07Controller extends AbstractController
{
    #[Route(['/ex07', '/ex07/'], name: 'app_ex07')]
    public function index(EntityManagerInterface $em): Response {
        $user = $em->getRepository(User::class)->findAll();
        return $this->render('ex07/index.html.twig', [
            'users' => $user,
        ]);
    }

    #[Route(['/ex07/update/{id}', '/ex07/update/{id}/'], name: 'app_ex07_edit')]
    public function edit(EntityManagerInterface $em, int $id, Request $request): Response {
        $user = $em->getRepository(User::class)->find($id);
        if (!$user) {
            $this->addFlash('failure', 'User not found!');
            return $this->redirectToRoute('app_ex07');
        }
        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->flush();
                $this->addFlash('success', 'Item succesfully updated!');
                    return $this->redirectToRoute('app_ex07');
            } catch (\Exception $e) {
                $this->addFlash('failure', 'Failed to update item!');
                return $this->redirectToRoute('app_ex07');
            }
        }
        return $this->render('ex07/edit.html.twig', [
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
