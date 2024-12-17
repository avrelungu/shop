<?php

namespace App\Service\Order;

use App\Entity\Order;
use App\Entity\OrderDetail;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Repository\OrderRepository;

class OrderService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ValidatorInterface $validator
    ) {
    }

    public function create(array $content): array
    {
        $errors = [];
        $order = new Order();

        $userId = $content['userId'] ?? null;
        if (!$userId) {
            $errors['userId'] = 'userId is required';
        } else {
            $user = $this->getUserById($userId);

            if (!$user) {
                $errors['userId'] = 'User does not exist';
            } else {
                $order->setUser($user);
            }
        }

        $orderDetailsData = $content['orderDetails'] ?? [];
        if (!$orderDetailsData || !is_array($orderDetailsData)) {
            $errors['orderDetails'] = 'Invalid orderDetails data';
        }

        $orderDetails = [];
        $amount = 0;
        foreach ($orderDetailsData as $index => $orderDetailData) {
            $orderDetail = $this->createOrderDetail($orderDetailData);
            $validationErrors = $this->validator->validate($orderDetail);

            if (count($validationErrors) > 0) {
                $errors['orderDetails'][$index] = (string)$validationErrors;
            } else {
                $amount += $orderDetail->getPrice() * $orderDetail->getQuantity();
                $orderDetails[] = $orderDetail;
                $order->addOrderDetail($orderDetail);
            }
        }

        if (empty($errors)) {
            $order->setStatus('pending');
            $order->setFingerprint($this->generateUniqueFingerprint());
            $order->setAmount($amount);
        }

        return [
            'errors' => $errors,
            'order' => $order,
        ];
    }

    public function updateOrderStatus(Order $order, array $content): Order
    {
        $newStatus = $content['status'] ?? null;

        if (!$newStatus || !in_array($newStatus, ['pending', 'completed', 'cancelled'])) {
            throw new \InvalidArgumentException('Invalid status');
        }

        if ($order->getStatus() === 'cancelled' && $newStatus === 'completed') {
            throw new \RuntimeException('Cannot change status from "cancelled" to "completed"');
        }

        $order->setStatus($newStatus);

        $errors = $this->validator->validate($order);
        if (count($errors) > 0) {
            throw new \RuntimeException((string) $errors);
        }

        $this->entityManager->flush();

        return $order;
    }

    public function getUserById(int $userId): ?User
    {
        return $this->entityManager->getRepository(User::class)->find($userId);
    }

    public function createOrderDetail(array $data): OrderDetail
    {
        $orderDetail = new OrderDetail();
        $orderDetail->setProduct($data['product'] ?? null);
        $orderDetail->setPrice((float)($data['price'] ?? 0));
        $orderDetail->setQuantity((int)($data['quantity'] ?? 0));

        return $orderDetail;
    }

    private function generateUniqueFingerprint(): string
    {
        return 'ORD_' . bin2hex(random_bytes(10));
    }

    public function getOrdersOfUser(int $userId): array
    {
        /** @var OrderRepository */
        $orderRepository = $this->entityManager->getRepository(Order::class);

        $orders = $orderRepository->findByUser($userId);

        $data = [
            'user' => $userId,
            'orders' => []
        ];

        foreach($orders as $order) {
            $orderDetails = [];
            foreach($order->getOrderDetails() as $orderDetail) {
                $orderDetails[] = [
                    'product' => $orderDetail->getProduct(),
                    'quantity' => $orderDetail->getQuantity(),
                    'price' => $orderDetail->getPrice()
                ];
            }

            $data['orders'][] = [
                'orderId' => $order->getId(),
                'orderDetails' => $orderDetails
            ];
        }

        return $data;
    }
}