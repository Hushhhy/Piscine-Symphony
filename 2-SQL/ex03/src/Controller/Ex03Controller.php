<?php

namespace App\Controller;

use App\Entity\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

final class Ex03Controller extends AbstractController
{
    #[Route(['/ex03', '/ex03/'], name: 'app_ex03')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $user = new User();
        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->persist($user);
                $em->flush();
                $this->addFlash('success', 'Table created successfully!');
                return $this->redirectToRoute('app_ex03');
            } catch (\Exception $e) {
                $this->addFlash('failure', 'Failed to create table!');
                return $this->redirectToRoute('app_ex03');
            }
        }
        $users = $em->getRepository(User::class)->findAll();
        return $this->render('ex03/index.html.twig', [
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

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

