<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\NoteFormType;

class NoteController extends AbstractController {

    #[Route('/e02')]
    public function index(Request $request): Response {
        $form = $this->createForm(NoteFormType::class);
        $form->handleRequest($request);
        $filename = $this->getParameter('note_file');
        $filepath = $this->getParameter('kernel.project_dir') . '/' . $filename;
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $message = $data['message'];
            if ($data['include_timestamp'] === true)
                $line = date('Y-m-d H:i:s') . '-' . $message;
            else 
                $line = $message;
            $line .= PHP_EOL;
            file_put_contents($filepath, $line, FILE_APPEND);
        }
        $lastline = null;
        if (file_exists($filepath)) {
            $lines = file($filepath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            if (!empty($lines))
                $lastline = end($lines);
        }
        return $this->render('note/index.html.twig', [
            'form' => $form,
            'last_line' => $lastline,
        ]);
    }
}