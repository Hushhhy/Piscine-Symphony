<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\HttpKernel\KernelInterface;

final class Ex01Controller extends AbstractController
{
    #[Route(['/ex01', '/ex01/'], name: 'app_ex01')]
    public function index(): Response
    {
        return $this->render('ex01/index.html.twig', [
            'controller_name' => 'Ex01Controller',
        ]);
    }

    #[Route(['/ex01/create', '/ex01/create/'], name: 'app_ex01_create')]
    public function create(KernelInterface $kernel): Response {
        try {
            $app = new Application($kernel);
            $app->setAutoExit(false);
            $input = new ArrayInput([
                'command' => 'doctrine:migrations:migrate',
                '--no-interaction' => true,
            ]);
            $output = new BufferedOutput();
            $app->run($input, $output);
            $this->addFlash('success', 'Table created successfully!');
            return $this->redirectToRoute('app_ex01');
        } catch (\Exception $e) {
            $this->addFlash('failure', 'Failed to create table!');
            return $this->redirectToRoute('app_ex01');
        }
    }
}
