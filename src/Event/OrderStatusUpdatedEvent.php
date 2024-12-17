<?php

namespace App\Event;

use App\Entity\Order;
use Symfony\Contracts\EventDispatcher\Event;

class OrderStatusUpdatedEvent extends Event
{
    public const NAME = 'order.status_updated';

    public function __construct(private Order $order) {}

    public function getOrder(): Order
    {
        return $this->order;
    }
}
