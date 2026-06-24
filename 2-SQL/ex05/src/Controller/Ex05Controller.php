<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;

final class Ex05Controller extends AbstractController
{
    #[Route(['/ex05', '/ex05/'], name: 'app_ex05')]
    public function index(EntityManagerInterface $em): Response
    {
        $user = $em->getRepository(User::class)->findAll();
        return $this->render('ex05/index.html.twig', [
            'users' => $user,
        ]);
    }

    #[Route(['/ex05/delete/{id}', '/ex05/delete/{id}/'], name: 'app_ex05_delete')]
    public function delete(EntityManagerInterface $em, int $id): Response {
        $user = $em->getRepository(User::class)->find($id);
        if ($user) {
            $em->remove($user);
            $em->flush();
            $this->addFlash('success', 'Item succesfully deleted!');
            return $this->redirectToRoute('app_ex05');
        }
        $this->addFlash('failure', 'Failed to delete item!');
            return $this->redirectToRoute('app_ex05');
    }
}
