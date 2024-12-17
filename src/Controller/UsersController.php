<?php

namespace App\Controller;

use App\Dto\UserDto;
use App\Entity\User;
use App\Service\Order\OrderService;
use App\Service\User\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class UsersController extends AbstractController
{
    #[Route(path: '/users/{id}/orders', name: 'user_orders', methods: ['GET'])]
    public function getUserOrders(Request $request, OrderService $orderService, SerializerInterface $serializer): JsonResponse
    {
        try {
            $userId =  $request->get('id', 0);

            $ordersOfUser = $orderService->getOrdersOfUser($userId);

            return new JsonResponse(
                $ordersOfUser,
                Response::HTTP_OK
            );
        } catch (\Throwable $exception) {
            throw $exception; 
        }
    }

    #[Route(path: '/users', name: 'user_create', methods: ['POST'])]
    public function store(Request $request, SerializerInterface $serializer, UserService $userService): JsonResponse
    {
        try {
            $userData = $serializer->deserialize($request->getContent(), User::class, 'json');    

            $user = $userService->create($userData);

            return new JsonResponse(
                $serializer->serialize($user, 'json', ['groups' => 'user:create']),
                Response::HTTP_CREATED
            );
        } catch (\Throwable $exception) {
            throw $exception; 
        }
    }
}
