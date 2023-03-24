<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{

    private $repoProduit;
    private $serializer;
    private $repoCat;
    public function __construct(ProductRepository $repoProduit, SerializerInterface $serializer, CategoryRepository $repoCat)
    {
        $this->repoProduit = $repoProduit;
        $this->serializer = $serializer;
        $this->repoCat = $repoCat;
    }

    #[Route('/product/add', name: 'app_product', methods: ['POST'])]
    public function index(Request $request): JsonResponse
    {

        // get request
        $request_data = json_decode($request->getContent(), true);

        // if product exist 
        $product = new Product();
        $verifUsername = $this->repoProduit->findOneByNom($request_data["nom"]);
        if ($verifUsername != null) {
            return $this->json([
                'code' => 401,
                'message' => "Ce nom d'utilisateur est déjà utilisé."
            ]);
        }
        $product->setNom($request_data["nom"]);
        $product->setDescription($request_data["description"]);
        $product->setStatus(false);

        $category = $this->repoCat->findOneById($request_data["cat_id"]);
        $product->setCategory($category);
        $this->repoProduit->save($product, true);

        return $this->json([
            'code' => 200,
            'message' => 'Enreg success',
        ]);
    }

    # Récupère les produits
    #[Route('/product/all', name: 'app_all_product', methods: ['GET'])]
    public function getAllProducts(): JsonResponse
    {
        $cats = $this->repoProduit->findAll();
        return $this->json([
            "code" => 200,
            "data" => $cats
        ], 200, [], ['groups' => ['show_product']]
        );
    }
}
