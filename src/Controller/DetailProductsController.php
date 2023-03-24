<?php

namespace App\Controller;

// use App\Entity\DetailProducts;
// use App\Repository\DetailProductsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class DetailProductsController extends AbstractController
{

//     private $repoDetailProducts;
//     public function __construct(DetailProductsRepository $repoDetailProducts)
//     {
//         $this->repoDetailProducts = $repoDetailProducts;
//     }
//     # Récupère tous les marchands
//     #[Route('/api/detailProducts', name: 'app_detailProducts', methods:['GET'])]
//     public function getAllDetailProducts(DetailProductsRepository $DetailProductsRepository, SerializerInterface $serializer): JsonResponse
//     {
//         $detailProducts = $DetailProductsRepository->findAll();
//         $detailProductsJson = $serializer->serialize($detailProducts, 'json');
//         return new JsonResponse($detailProductsJson, Response::HTTP_OK, [], true);
//     }

//     # Route pour récupérer un marchand par son id
//     #[Route('/api/detailProducts/{id}', name: 'eachDetailProducts', methods: ['GET'])]
//     public function eachDetailProducts($id, DetailProductsRepository $DetailProductsRepository, SerializerInterface $serializer): JsonResponse
//     {   
//         // Code simplifié avec le param converter : vérifie si l'id existe et si oui, retourne le marchand
//         $detailProducts = $this->repoDetailProducts->findOneById($id);
//         $detailProductsJson = $serializer->serialize($detailProducts, 'json');
//         return new JsonResponse($detailProductsJson, Response::HTTP_OK, [], true);
        
//     }
    
//     # Supprime un Marchand
//     #[Route('/api/detailProducts/delete/{id}', name:'deleteDetailProducts', methods:['DELETE'])]
//     public function deleteDetailProducts( $id, EntityManagerInterface $delete): JsonResponse
//     {   

//         //dd( $this->repoMarchand->findOneById($id) );
//         $delete->remove($this->repoDetailProducts->findOneById($id));
//         $delete->flush();
//         return new JsonResponse('produit supprimé avec succès', Response::HTTP_OK);
//     }

//     # Ajoute un Marchand
//     #[Route('/api/detailProducts/create', name: 'addDetailProducts', methods:['POST'])]
//     public function addProducts(Request $request, EntityManagerInterface $add, SerializerInterface $serializer): JsonResponse
//     {
//         $detailProducts = $serializer->deserialize($request->getContent(), DetailProducts::class, 'json');
//         $add->persist($detailProducts);
//         $add->flush();

//         $jsonDetailProducts = $serializer->serialize($detailProducts, 'json');
//         return new JsonResponse($jsonDetailProducts, Response::HTTP_CREATED, [], true);
//     }
    

//   # Modifie un marchand par son id
//   #[Route('/api/detailProducts/update/{id}', name: 'updateDetailProducts', methods: ['PUT'])]
//   public function updateDetailProducts($id, Request $request, EntityManagerInterface $update, SerializerInterface $serializer): JsonResponse
//   {
//     $detailProducts = $this->repoDetailProducts->findOneById($id);
//       $detailProducts = $serializer->deserialize($request->getContent(), DetailProducts::class, 'json', ['object_to_populate' => $detailProducts]);
//       $update->persist($detailProducts);
//       $update->flush();

//       $jsonDetailProducts = $serializer->serialize($detailProducts, 'json');
//       return new JsonResponse($jsonDetailProducts, Response::HTTP_OK, [], true);
//   }   

}
