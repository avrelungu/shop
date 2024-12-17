<?php

namespace App\Service\Notification;

use App\Entity\Order;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Notifier\Recipient\Recipient;

class NotificationService
{
    public function __construct(
        private NotifierInterface $notifier
    ) {
    }

    public function sendEmail(Order $order)
    {
        $orderId = $order->getId();

        $notification = (new Notification('New notification de la Aurel'))
            ->content("Salut, you got a new notification for order $orderId .");

        $recipient = new Recipient(
            // 'lunguaurel21@gmail.com'
            $order->getUser()->getEmail()
        );

        $this->notifier->send($notification, $recipient);
    }
}