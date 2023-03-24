<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\CommandePost;
use App\Repository\ClientRepository;
use App\Repository\CommandePostRepository;
use App\Repository\CommandeRepository;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommandeController extends AbstractController
{

    private $cmdRepo;
    private $postRepo;
    private $clientRepo;
    private $cmdPostRepo;
    private $em;
    public function __construct(CommandeRepository $cmdRepo, ClientRepository $clientRepo, PostRepository $postRepo, CommandePostRepository $cmdPostRepo,
    EntityManagerInterface $em) {
        $this->cmdRepo = $cmdRepo;
        $this->clientRepo = $clientRepo;
        $this->postRepo = $postRepo;
        $this->cmdPostRepo = $cmdPostRepo;
        $this->em = $em;
    }

    #[Route('/commande/add', name: 'app_commande_add', methods: ['POST'])]
    public function addCmde(Request $request): JsonResponse
    {
        // get data request
        $request_data = json_decode($request->getContent(), true);
        $commande = new Commande();

        $montantTotalCmd = 0;
        // save all details commande
        foreach ($request_data["details"] as $key => $element) {

            // set commandePost
            $cmdPost = new CommandePost();
            $cmdPost->setQuantite($element["quantite"]);
            $cmdPost->setPrix($element["prix"]);
            // get post about cmdPost
            $post = $this->postRepo->findOneById($element["post_id"]);
            $cmdPost->setPost($post);
            $cmdPost->setCommande($commande);
            $this->cmdPostRepo->save($cmdPost, false);

            // increment commande montant
            $montantTotalCmd = $montantTotalCmd + $element["prix"];
        }

        // set client commande
        $client = $this->clientRepo->findOneById($request_data["client_id"]);

        $commande->setMontantTotal($montantTotalCmd);
        $commande->setClient($client);

        // save commande
        $this->cmdRepo->save($commande, true);
        $this->em->flush();

        return $this->json([
            'code' => 200,
            'message' => 'Emreg Ok',
        ]);
    }

    # Récupère les commandes
    #[Route('/commande/all', name: 'app_commande_all', methods: ['GET'])]
    public function getAllClient(): JsonResponse
    {
        $commandes = $this->cmdRepo->findAll();
        return $this->json([
                "code" => 200,
                "data" => $commandes
            ], 200, [], ['groups' => ['show_commande']]
        );
    }

}
