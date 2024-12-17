<?php

namespace App\EventListener;

use App\Event\OrderStatusUpdatedEvent;
use App\Service\Notification\NotificationService;
use Psr\Log\LoggerInterface;

class OrderStatusUpdatedListener
{
    public function __construct(
        private LoggerInterface $logger,
        private NotificationService $notificationService
    ) {}

    public function onOrderStatusUpdated(OrderStatusUpdatedEvent $event): void
    {
        $order = $event->getOrder();

        $this->notificationService->sendEmail($order);
    }
}
