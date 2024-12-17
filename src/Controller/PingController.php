<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PingController extends AbstractController
{
    #[Route(path: '/', name: 'ping', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {
        $info = [
            'app' => 'shop-interview',
            'env' => $this->getParameter('kernel.environment'),
            'user-agent' => $request->headers->get('user-agent'),
        ];

        return $this->json($info, Response::HTTP_OK);
    }
}
