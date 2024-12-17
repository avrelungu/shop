<?php

namespace App\DataFixtures;

use App\Entity\Order;
use App\Entity\OrderDetail;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OrderFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Users fixtures
        $users = [
            [1, 'John Doe', 'CTR242002121109@venden.lv', '1997-12-12'],
            [2, 'Alex Manea', 'alex.manea@bobnet.tech', '1997-12-12'],
            [3, 'Maintainer Saku', 'saku.maintainer@bobnet.ro', '1997-12-12'],
            [4, 'Courier Saku', 'saku.courier@bobnet.ro', '1997-12-12'],
            [5, 'Picker Saku', 'saku.picker@bobnet.ro', '1997-12-12'],
            [6, 'Owner Saku', 'saku.owner@bobnet.ro', '1987-12-12'],
            [7, 'Saku Api', 'saku.api@bobnet.ro', '1987-12-12'],
            [8, 'Yagiz Yazicilar', 'yagiz.mujdat@multinode.ro', '1987-12-12'],
            [9, 'Courier Dev Nicolae', 'courier.nicolae@bobnet.ro', '1987-12-12'],
            [10, 'Bujor Bohdan', 'bogdan.bujor@multinode.ro', '1987-12-12'],
        ];

        // Products fixtures
        $products = [
            ['Nutella Crema Tartinabila Cu Alune Si Cacao 750g', 21.81],
            ['310 G Daucy Linte', 5.04],
            ['25p Lipton Yellow Label Ceai Negru', 12.54],
            ['25p-lipton-balance-green-tea-mint-ceai-verde-cu-menta', 13.30],
            ['1l Muller Lapte Uht 3,5%', 5.90],
            ['1l Muller Lapte Uht 1,5%', 5.23],
            ['100g Davidoff Le Topaz Cafea Instant', 25.17],
            ['450g Zanae Ardei Capia Copt', 10.25],
            ['Fineti Crema De Cacao&alune 1kg', 22.03],
            ['Nesquik Cereale 500g', 12.35],
        ];

        foreach ($users as [$id, $name, $email, $birthdate]) {
            // Create a User
            $user = new User();
            $user->setName($name);
            $user->setEmail($email);
            $user->setBirthDate(\DateTimeImmutable::createFromFormat('Y-m-d', $birthdate));
            $manager->persist($user);

            // Create Order Details
            [$product1, $price1] = $products[$id % 10];
            [$product2, $price2] = $products[($id + 1) % 10];

            $orderDetail1 = new OrderDetail();
            $orderDetail1->setProduct($product1);
            $orderDetail1->setPrice($price1);
            $orderDetail1->setQuantity(1);
            $manager->persist($orderDetail1);

            $orderDetail2 = new OrderDetail();
            $orderDetail2->setProduct($product2);
            $orderDetail2->setPrice($price2);
            $orderDetail2->setQuantity(2);
            $manager->persist($orderDetail2);

            // Create Orders
            $order1 = new Order();
            $order1->setUser($user);
            $order1->setStatus('pending');
            $order1->addOrderDetail($orderDetail1);
            $order1->addOrderDetail($orderDetail2);
            $manager->persist($order1);

            $order2 = new Order();
            $order2->setUser($user);
            $order2->setStatus('completed');
            $order2->addOrderDetail($orderDetail2);
            $manager->persist($order2);
        }

        $manager->flush();
    }
}
