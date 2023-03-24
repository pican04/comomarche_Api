<?php

namespace App\Controller;

// use App\Entity\StockList;
// use App\Repository\StockListRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class StockListController extends AbstractController
{

//     private $repoStockList;
//     public function __construct(StockListRepository $repoStockList)
//     {
//         $this->repoStockList = $repoStockList;
//     }
//     # Récupère tous les marchands
//     #[Route('/api/stockList', name: 'app_stockList', methods:['GET'])]
//     public function getAllStockList(stockListRepository $StockListRepository, SerializerInterface $serializer): JsonResponse
//     {
//         $stockList = $StockListRepository->findAll();
//         $stockListJson = $serializer->serialize($stockList, 'json');
//         return new JsonResponse($stockListJson, Response::HTTP_OK, [], true);
//     }

//     # Route pour récupérer un marchand par son id
//     #[Route('/api/stockList/{id}', name: 'eachStockList', methods: ['GET'])]
//     public function eachStockList($id, StockListRepository $StockListRepository, SerializerInterface $serializer): JsonResponse
//     {   
//         // Code simplifié avec le param converter : vérifie si l'id existe et si oui, retourne le marchand
//         $stockList = $this->repoStockList->findOneById($id);
//         $stockListJson = $serializer->serialize($stockList, 'json');
//         return new JsonResponse($stockListJson, Response::HTTP_OK, [], true);
        
//     }
    
//     # Supprime un Marchand
//     #[Route('/api/stockList/delete/{id}', name:'deleteStockList', methods:['DELETE'])]
//     public function deleteStockList( $id, EntityManagerInterface $delete): JsonResponse
//     {   

//         //dd( $this->repoMarchand->findOneById($id) );
//         $delete->remove($this->repoStockList->findOneById($id));
//         $delete->flush();
//         return new JsonResponse('produit supprimé avec succès', Response::HTTP_OK);
//     }

//     # Ajoute un Marchand
//     #[Route('/api/stockList/create', name: 'addStockList', methods:['POST'])]
//     public function addStockList(Request $request, EntityManagerInterface $add, SerializerInterface $serializer): JsonResponse
//     {
//         $stockList = $serializer->deserialize($request->getContent(), StockList::class, 'json');
//         $add->persist($stockList);
//         $add->flush();

//         $jsonStockList = $serializer->serialize($stockList, 'json');
//         return new JsonResponse($jsonStockList, Response::HTTP_CREATED, [], true);
//     }
    

//   # Modifie un marchand par son id
//   #[Route('/api/stockList/update/{id}', name: 'updateStockList', methods: ['PUT'])]
//   public function updateStockList($id, Request $request, EntityManagerInterface $update, SerializerInterface $serializer): JsonResponse
//   {
//     $stockList = $this->repoStockList->findOneById($id);
//       $stockList = $serializer->deserialize($request->getContent(), StockList::class, 'json', ['object_to_populate' => $stockList]);
//       $update->persist($stockList);
//       $update->flush();

//       $jsonStockList = $serializer->serialize($stockList, 'json');
//       return new JsonResponse($jsonStockList, Response::HTTP_OK, [], true);
//   }   

}
