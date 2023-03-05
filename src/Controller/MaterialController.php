<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Material;
use App\Entity\MaterialPicture;
use App\Form\CategoryResearchType;
use App\Form\MaterialType;
use App\Repository\MaterialRepository;
use App\Security\Voter\UserVoter;
use App\Services\Localisation;
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
    public function __construct(private MaterialRepository $materialRepository, private Localisation $localisation)
    {
    }

    #[Route('/material', name: 'app_material_list')]
    public function materialList(Request $request): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryResearchType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->get('name')->getData();
            $materials = $category->getMaterial();
            return $this->render('material/list.html.twig', ['materials' => $materials, 'form' => $form]);
        }

        $materials = $this->materialRepository->findAll();
        return $this->render('material/list.html.twig', ['materials' => $materials, 'form' => $form]);
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

                if ($materialPicture) {
                    $entityManager->persist($materialPicture);
                }
            }
            $material
                ->setOwner($this->getUser())
                ->setUuid(Uuid::v4());
            //dd($material);


            $entityManager->persist($material);
            $entityManager->flush();
            return $this->redirectToRoute('app_home');
        }
        return $this->render('material/new.html.twig', ['form' => $form]);
    }

    #[Route('/material/{uuid}', name: 'app_material_details')]
    public function materialDetails(Material $material): Response
    {
        $distance = 'Distance inconnue';
        if ($this->getUser()) {
            $distance = $this->localisation->getDistance(
                ['latitude' => $this->getUser()->getLatitude(), 'longitude' => $this->getUser()->getLongitude()],
                [
                    'latitude' => $material->getOwner()->getLatitude(),
                    'longitude' => $material->getOwner()->getLongitude()
                ]
            );

        }
        $address = $this->localisation->getAddress(
            $material->getOwner()->getLatitude(),
            $material->getOwner()->getLongitude()
        );
        $trades = $material->getTrades();
        return $this->render('material/details.html.twig', ['material' => $material, 'trades' => $trades, 'address' => $address, 'distance' => $distance]);
    }

    private function getDoctrine()
    {
    }


}
