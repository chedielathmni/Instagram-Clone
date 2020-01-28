<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Profile;
use App\Entity\User;

class ProfileController extends AbstractController
{
    /**
     * @Route("/{slug}-{id}", name="profile.show", requirements={"slug": "[a-z0-9\-]*"})
     * @param Profile $profile
     * @param string $slug
     * @return Response
     */
    public function show(User $user, string $slug): Response
    {
        dump($user);
        if ($user->getSlug() !== $slug) {
            return $this->redirectToRoute('profile.show', [
                'id' => $user->getId(),
                'slug' => $user->getSlug()
            ], 301);
        }
        return $this->render('profile\show.html.twig', [
            'user' => $user,
            'Current_menu' => 'profile'
        ]);
    }


    /**
     * @Route("/{slug}-{id}/edit", name="profile.edit")
     * @param User $user
     * @param string $slug
     * @return Response
     */
    public function edit(User $user, string $slug): Response
    {
        if ($user->getSlug() !== $slug) {
            return $this->redirectToRoute('profile.show', [
                'id' => $user->getId(),
                'slug' => $user->getSlug()
            ], 301);
        }

        return $this->render('profile\edit.html.twig', compact($user));
    }
}
