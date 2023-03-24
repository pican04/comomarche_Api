<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use App\Repository\MarchandRepository;
use App\Repository\ProductRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class PostController extends AbstractController
{

    private $marchandRepo;
    private $repoPost;
    private $repoProduct;
    public function __construct(PostRepository $repoPost, MarchandRepository $marchandRepo, ProductRepository $repoProduct) {
        $this->repoPost = $repoPost;
        $this->marchandRepo = $marchandRepo;
        $this->repoProduct = $repoProduct;
    }

    #[Route('/post/add', name: 'app_post', methods: ['POST'])]
    public function index(Request $request): JsonResponse
    {

        // get data request
        $request_data = json_decode($request->getContent(), true);
        $post = new Post();
        $post->setPrix($request_data["prix"]);
        $post->setPrixMax($request_data["prixMax"]);
        $post->setPrixMin($request_data["prixMin"]);
        $post->setUnite($request_data["unite"]);
        $post->setDescription($request_data["description"]);

        // get marchand
        $marchand = $this->marchandRepo->findOneById($request_data["marchandId"]);
        // get product
        $product = $this->repoProduct->findOneById($request_data["productId"]);

        // save marchand - product in post
        $post->setProduct($product);
        $post->setMarchand($marchand);
        $this->repoPost->save($post, true);

        return $this->json([
            'code' => 200,
            'message' => 'Enreg Ok',
        ]);
    }

    # Récupère les posts
    #[Route('/post/all', name: 'app_post_all', methods: ['GET'])]
    public function getAllPosts(): JsonResponse
    {
        $posts = $this->repoPost->findAll();
        return $this->json([
            "code" => 200,
            "data" => $posts
        ], 200, [], ['groups' => ['show_post']]
        );
    }

    #[Route('/post/search', name: 'app_post_search', methods: ['POST'])]
    public function searchPost(Request $request): JsonResponse
    {
        // get data request
        $request_data = json_decode($request->getContent(), true);
        $resultats = $this->repoPost->recherchePost( $request_data["produitLibelle"] );

        return $this->json([
            "code" => 200,
            "data" => $resultats
        ], 200, [], ['groups' => ['show_post']]
        );
    }

}
