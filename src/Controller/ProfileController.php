<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ProfileController extends AbstractController
{
    /**
     * @Route("/profile")
     */
    public function number()
    {
        $number = random_int(0, 100);

        return $this->render('profile.html.twig', [
            'number' => $number,
        ]);
    }
}
