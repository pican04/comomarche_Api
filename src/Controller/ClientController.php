<?php

namespace App\Controller;

use App\Entity\Client;
use App\Repository\ClientRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ClientController extends AbstractController
{
    private $clientRepo;
    private $passwordHasher;
    public function __construct(UserPasswordHasherInterface $passwordHasher, ClientRepository $clientRepo) {
        $this->passwordHasher = $passwordHasher;
        $this->clientRepo = $clientRepo;
    }

    #[Route('/client/add', name: 'app_client', methods: ['POST'])]
    public function index(Request $request): JsonResponse
    {

        // get data request
        $request_data = json_decode($request->getContent(), true);
        $client = new Client();

        // check if username exist
        $verifUsername = $this->clientRepo->findOneByUsername($request_data["username"]);
        if ($verifUsername != null) {
            return $this->json([
                'code' => 401,
                'message' => "Ce username de marchand est déjà utilisé."
            ]);
        }

        $client->setUsername($request_data["username"]);
        // hash the password (based on the security.yaml config for the $user class)
        $hashedPassword = $this->passwordHasher->hashPassword($client, $request_data["password"]);
        $client->setPassword($hashedPassword);
        $client->setNom($request_data["nom"]);
        $client->setPrenom($request_data["prenom"]);
        $client->setEmail($request_data["email"]);
        $client->setTelephone($request_data["telephone"]);
        $client->setRoles( array('ROLE_CLIENT') );

        // save clien$client
        $this->clientRepo->save($client, true);

        return $this->json([
            'code' => 200,
            'message' => 'Emreg Ok',
        ]);
    }

    # Récupère les client
    #[Route('/client/all', name: 'app_client_all', methods: ['GET'])]
    public function getAllClient(): JsonResponse
    {
        $clients = $this->clientRepo->findAll();
        return $this->json([
            "code" => 200,
            "data" => $clients
        ], 200, [], ['groups' => ['show_client']]
        );
    }


}
