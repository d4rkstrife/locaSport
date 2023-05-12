<?php

namespace App\Controller;

use App\Entity\ProfilPicture;
use App\Entity\User;
use App\Form\UserType;
use App\Services\Localisation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Uid\Uuid;

class RegisterController extends AbstractController
{
    public function __construct(private Localisation $localisation)
    {

    }
    #[Route('/register', name: 'app_register')]
    public function addUser(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $userPasswordHasher,
        SluggerInterface $slugger
    ): Response {
        $article = new User();
        $form = $this->createForm(UserType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $pictureFiles = $form->get('profilPicture')->getData();

            foreach ($pictureFiles as $pictureFile) {
                $originalFilename = pathinfo($pictureFile->getClientOriginalName(), PATHINFO_FILENAME);

                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);

                $newFilename = $safeFilename . '-' . uniqid() . '.' . $pictureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $pictureFile->move(
                        $this->getParameter('profilPictureDirectory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file uploads
                }
                $profilPicture = new ProfilPicture();
                $profilPicture->setLink($newFilename);
                $user->setProfilPicture($profilPicture);
            }

            $coords = $this->localisation->getCoords($form->get('address')->getData());
            $user->setLongitude($coords['longitude']);
            $user->setLatitude($coords['latitude']);
            $user->setPassword($userPasswordHasher->hashPassword($user, $user->getPassword()));
            $user->setUuid(Uuid::v4());
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', "Vous êtes enregistré. Veuillez vous connecter");
            return $this->redirectToRoute('app_login');
        }
        return $this->render('register/add.html.twig', [
            'form' => $form,
        ]);
    }
}
