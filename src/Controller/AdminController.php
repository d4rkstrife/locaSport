<?php

namespace App\Controller;

use App\Entity\Material;
use App\Entity\User;
use App\Repository\MaterialRepository;
use App\Repository\UserRepository;
use App\Security\Voter\UserVoter;
use App\Services\Localisation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    public function __construct(private Localisation $localisation)
    {
    }

    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        if (!$this->isGranted(UserVoter::ACCESS)) {
            $this->redirectToRoute('app_home');
        }
        return $this->render('admin/index.html.twig');
    }

    #[Route('/admin/posts', name: 'app_admin_posts')]
    public function adminAllPosts(): Response
    {
        if (!$this->isGranted(UserVoter::ACCESS)) {
            $this->redirectToRoute('app_home');
        }
        return $this->render('admin/postsList.html.twig');
    }

    #[Route('/admin/materials', name: 'app_admin_materials')]
    public function adminAllMaterials(MaterialRepository $materialRepository): Response
    {
        if (!$this->isGranted(UserVoter::ACCESS)) {
            $this->redirectToRoute('app_home');
        }
        $materials = $materialRepository->findAll();
        return $this->render('admin/material/list.html.twig', ['materials' => $materials]);
    }

    #[Route('/admin/users', name: 'app_admin_users')]
    public function list(UserRepository $userRepository): Response
    {
        if (!$this->isGranted(UserVoter::ACCESS, $this->getUser())) {
            return $this->redirectToRoute('app_home');
        }
        $users = $userRepository->findBy([], ['name' => 'ASC']);
        return $this->render('admin/user/list.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/admin/user/{uuid}', name: 'app_admin_user_details')]
    public function userDetails(User $user, UserRepository $userRepository): Response
    {
        if (!$this->isGranted(UserVoter::ACCESS, $this->getUser())) {
            return $this->redirectToRoute('app_home');
        }
        $address = $this->localisation->getAddress($user->getLatitude(), $user->getLongitude());

        return $this->render('admin/user/details.html.twig', [
            'user' => $user,
            'address' => $address
        ]);
    }
    #[Route('/admin/material/{uuid}', name: 'app_admin_material_details')]
public function materialDetails(Material $material): Response
    {
        if (!$this->isGranted(UserVoter::ACCESS, $this->getUser())) {
            return $this->redirectToRoute('app_home');
        }
        $address = $this->localisation->getAddress($material->getOwner()->getLatitude(), $material->getOwner()->getLongitude());
        return $this->render('admin/material/details.html.twig', ['material'=>$material, 'address'=>$address]);
    }
}
