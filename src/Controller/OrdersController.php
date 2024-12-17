<?php

namespace App\Controller;

use App\Entity\Order;
use App\Event\OrderStatusUpdatedEvent;
use App\Service\Order\OrderService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class OrdersController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
        
    }

    #[Route(path: '/orders', name: 'orders_create', methods: ['POST'])]
    public function create(
        Request $request,
        SerializerInterface $serializer,
        OrderService $orderService
    ): JsonResponse {
        try {
            $content = json_decode($request->getContent(), true);

            $userId = $content['userId'] ?? null;
            if(!$userId) {
                throw new NotFoundHttpException('Please provide a User ID.');
            }

            [$errors, $order] = $orderService->create($content);

            if ($errors) {
                return $this->json(['errors' => $errors], Response::HTTP_BAD_REQUEST);
            }
        
            $this->entityManager->persist($order);
            $this->entityManager->flush();
        
            $data = $serializer->serialize($order, 'json', ['groups' => ['order:read']]);

            return new JsonResponse($data, Response::HTTP_CREATED, [], true);
        } catch (\Throwable $exception) {
            throw new $exception;
        }
    }


    #[Route('/orders/{id}', name: 'orders_update_status', methods: ['PUT'])]
    public function updateStatus(
        Order $order, 
        Request $request, 
        OrderService $orderService, 
        EventDispatcherInterface $eventDispatcher
    ): JsonResponse {
        
        try {
            $content = json_decode($request->getContent(), true);

            $order = $orderService->updateOrderStatus($order, $content);

            if ($order->getStatus() === 'completed') {
                $eventDispatcher->dispatch(new OrderStatusUpdatedEvent($order), OrderStatusUpdatedEvent::NAME);
            }

            return new JsonResponse(['message' => 'Order status updated'], Response::HTTP_OK);
        } catch (\InvalidArgumentException $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (\RuntimeException $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (\Throwable $exception) {
            dd($exception->getMessage());
            throw new $exception;
        }
    }
}
