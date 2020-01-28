<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Profile;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class ProfileController extends AbstractController
{


    /**
     * @var UserRepository
     */
    private $repository;

    public function __construct(UserRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }


    /**
     * @Route("/{slug}-{id}", name="profile.show", requirements={"slug": "[a-z0-9\-]*"})
     * @param Profile $profile
     * @param string $slug
     * @return Response
     */
    public function show(User $user): Response
    {
        dump($user);
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
    public function edit(string $slug, Request $req): Response
    {
        $user = $this->getUser();
        if ($user->getSlug() !== $slug) {
            return $this->redirectToRoute('home');
        }

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            return $this->redirectToRoute('profile.show', [
                'id' => $user->getId(),
                'slug' => $user->getSlug()
            ]);
        }



        return $this->render('profile\edit.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }
}
