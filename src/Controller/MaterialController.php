<?php

namespace App\Controller;

use App\Entity\Material;
use App\Repository\MaterialRepository;
use Doctrine\Tests\Common\DataFixtures\TestValueObjects\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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

    #[Route('/material/{uuid}', name: 'app_material_details')]
    public function materialDetails(Material $material): Response
    {
        return $this->render('material/details.html.twig', ['material' => $material]);
    }
}
