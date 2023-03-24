<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{

    private $repoCat;
    private $serializer;
    public function __construct(CategoryRepository $repoCat, SerializerInterface $serializer) {
        $this->repoCat = $repoCat;
        $this->serializer = $serializer;
    }

    # Ajoute une cat
    #[Route('/category/create', name: 'app_add_category', methods:['POST'])]
    public function addCategory(Request $request): JsonResponse
    {
        $newCategory = $this->serializer->deserialize($request->getContent(), Category::class, 'json');
        $this->repoCat->save($newCategory, true);

        $jsonnewCategory = $this->serializer->serialize($newCategory, 'json');
        return new JsonResponse($jsonnewCategory, Response::HTTP_CREATED, [], true);
    }

    # Récupère les category
    #[Route('/category/all', name: 'app_all_cat', methods:['GET'])]
    public function getAllCategory(): JsonResponse
    {
        $cats = $this->repoCat->findAll();
        return $this->json([
            "code" => 200,
            "data" => $cats
            ], 200, [], ['groups' => ['show_category']]
        );
    }

    
}
