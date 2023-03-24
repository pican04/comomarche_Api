<?php

namespace App\Controller;

use App\Entity\Marchand;
use App\Repository\MarchandRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class MarchandController extends AbstractController
{

    private $marchandRepo;
    private $passwordHasher;
    public function __construct(UserPasswordHasherInterface $passwordHasher, MarchandRepository $marchandRepo) {
        $this->passwordHasher = $passwordHasher;
        $this->marchandRepo = $marchandRepo;
    }

    #[Route('/marchand/add', name: 'app_marchand', methods: ['POST'])]
    public function index(Request $request): JsonResponse
    {

        // get data request
        $request_data = json_decode($request->getContent(), true);
        $user = new Marchand();

        // check if username exist
        $verifUsername = $this->marchandRepo->findOneByUsername($request_data["username"]);
        if ($verifUsername != null) {
            return $this->json([
                'code' => 401,
                'message' => "Ce username de marchand est déjà utilisé."
            ]);
        }

        $user->setUsername($request_data["username"]);
        // hash the password (based on the security.yaml config for the $user class)
        $hashedPassword = $this->passwordHasher->hashPassword($user, $request_data["password"]);
        $user->setPassword($hashedPassword);
        $user->setNom($request_data["nom"]);
        $user->setPrenom($request_data["prenom"]);
        $user->setTelephone($request_data["telephone"]);
        $user->setCommune($request_data["commune"]);
        $user->setDetails($request_data["details"]);
        $user->setRoles( array('ROLE_MARCHAND') );

        // save user
        $this->marchandRepo->save($user, true);

        return $this->json([
            'code' => 200,
            'message' => 'Emreg Ok',
        ]);
    }

    # Récupère les marchands
    #[Route('/marchand/all', name: 'app_marchand_all', methods: ['GET'])]
    public function getAllMarchand(): JsonResponse
    {
        $marchands = $this->marchandRepo->findAll();
        return $this->json([
            "code" => 200,
            "data" => $marchands
        ], 200, [], ['groups' => ['show_marchand']]
        );
    }

    # Récupère un marchand
    #[Route('/marchand/{id}', name: 'app_marchand_ome', methods: ['GET'])]
    public function getOneMarchand($id): JsonResponse
    {
        $marchand = $this->marchandRepo->findOneById($id);
        return $this->json([
            "code" => 200,
            "data" => $marchand
        ], 200, [], ['groups' => ['show_marchand']]
        );
    }

}
