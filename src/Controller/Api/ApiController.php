<?php

namespace App\Controller;

use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    #[Route('/api_user', name: 'app_api_user')]
    public function userList(UsersRepository $ur): Response
    {
        $userList = $ur->findAll();

        return $this->json(
            // La liste des user à sérialiser
            $userList,
            // Code de retour HTTP
            200,
            // Tableau des headers complémentaires à envoyer 
            // Avec la ack/login/index.html.twig', réponse
            [],
            // Groupes a envoyer avec la réponse
            ['groups' => 'get_user']
        );
    }
}
