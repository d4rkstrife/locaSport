<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Security\Voter\UserVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/users', name: 'app_user')]
    public function list(UserRepository $userRepository): Response
    {
        if (!$this->isGranted(UserVoter::ACCESS, $this->getUser())){
            dd('false');
            return $this->redirectToRoute('app_home');
        }
        $users = $userRepository->findBy([], ['name' => 'ASC']);
        return $this->render('user/list.html.twig', [
            'users' => $users,
        ]);
    }
}
