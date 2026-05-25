<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ColorController extends AbstractController {

    #[Route('/e03')]
    public function index(): Response {
        $numShades = $this->getParameter('e03.number_of_colors');

        $colors = [
            'black' => [0, 0, 0],
            'red'   => [255, 0, 0],
            'blue'  => [0, 0, 255],
            'green' => [0, 128, 0],
        ];

        $shades = [];
        foreach ($colors as $name => $base) {
            $colorShades = [];
            for ($i = 0; $i < $numShades; $i++) {
                $factor = ($numShades > 1) ? $i / ($numShades - 1) : 1;
                $r = (int) round($base[0] * $factor);
                $g = (int) round($base[1] * $factor);
                $b = (int) round($base[2] * $factor);
                $colorShades[] = sprintf('rgb(%d, %d, %d)', $r, $g, $b);
            }
            $shades[$name] = $colorShades;
        }

        return $this->render('colors/index.html.twig', [
            'colors' => array_keys($colors),
            'shades' => $shades,
            'num_shades' => $numShades,
        ]);
    }
}
