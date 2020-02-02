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
use Symfony\Component\Validator\Constraints\Length;

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
        $posts = $user->getPosts()->getValues();
        return $this->render('profile\show.html.twig', [
            'user' => $user,
            'posts' => $posts,
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



    /**
     * @Route("/{slug}-{id}/follow", name="follow", requirements={"slug": "[a-z0-9\-]*"})
     * @param User user
     * @param string slug
     * @return Response
     */
    public function follow(User $user): Response
    {
        $userPro = $this->getUser()->getProfile();
        $userPro->addFollowing($user->getId());
        $user->getProfile()->addFollowers($userPro->getId());
        $this->em->flush();
        return $this->render('profile/follow.html.twig');
    }
    /**
     * @Route("/{slug}-{id}/unfollow", name="unfollow", requirements={"slug": "[a-z0-9\-]*"})
     * @param User user
     * @param string slug
     * @return Response
     */
    public function unfollow(User $user): Response
    {
        $user->getProfile()->removeFollower($this->getUser()->getId());
        $this->getUser()->getProfile()->removeFollowing($user->getId());
        $this->em->flush();
        return $this->render('profile/unfollow.html.twig');
    }
}
