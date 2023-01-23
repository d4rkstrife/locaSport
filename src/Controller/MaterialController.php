<?php

namespace App\Controller;

use App\Entity\Material;
use App\Entity\MaterialPicture;
use App\Form\MaterialType;
use App\Repository\MaterialRepository;
use App\Security\Voter\UserVoter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Uid\Uuid;

class MaterialController extends AbstractController
{
    public function __construct(private MaterialRepository $materialRepository)
    {
    }

    #[Route('/material', name: 'app_material_list')]
    public function materialList(): Response
    {
        $materials = $this->materialRepository->findAll();
        return $this->render('material/list.html.twig', ['materials' => $materials]);
    }


    #[Route('/material/new', name: 'app_material_new')]
    public function materialNew(
        Request $request,
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger
    ): Response {
        if (!$this->isGranted(UserVoter::VIEW, $this->getUser())) {
            return $this->redirectToRoute('app_login');
        }
        $material = new Material();
        $form = $this->createForm(MaterialType::class, $material);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $material = $form->getData();
            $pictureFiles = $form->get('materialPicture')->getData();

            foreach ($pictureFiles as $pictureFile) {
                $originalFilename = pathinfo($pictureFile->getClientOriginalName(), PATHINFO_FILENAME);

                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);

                $newFilename = $safeFilename . '-' . uniqid() . '.' . $pictureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $pictureFile->move(
                        $this->getParameter('materialImageDirectory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file uploads
                }
                $materialPicture = new MaterialPicture();
                $materialPicture->setLink($newFilename);
                $material->addMaterialPicture($materialPicture);
            }
            $material
                ->setOwner($this->getUser())
                ->setUuid(Uuid::v4());
            //dd($material);
            if($materialPicture){
                $entityManager->persist($materialPicture);
            }

            $entityManager->persist($material);
            $entityManager->flush();
            return $this->redirectToRoute('app_home');
        }
        return $this->render('material/new.html.twig', ['form' => $form]);
    }

    #[Route('/material/{uuid}', name: 'app_material_details')]
    public function materialDetails(Material $material): Response
    {
        $trades = $material->getTrades();
        return $this->render('material/details.html.twig', ['material' => $material, 'trades' => $trades]);
    }
}
