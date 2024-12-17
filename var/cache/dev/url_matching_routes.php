<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/orders' => [[['_route' => 'orders_create', '_controller' => 'App\\Controller\\OrdersController::create'], null, ['POST' => 0], null, false, false, null]],
        '/' => [[['_route' => 'ping', '_controller' => 'App\\Controller\\PingController::index'], null, ['GET' => 0], null, false, false, null]],
        '/users' => [[['_route' => 'user_create', '_controller' => 'App\\Controller\\UsersController::store'], null, ['POST' => 0], null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/_error/(\\d+)(?:\\.([^/]++))?(*:35)'
                .'|/orders/([^/]++)(*:58)'
                .'|/users/([^/]++)/orders(*:87)'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        35 => [[['_route' => '_preview_error', '_controller' => 'error_controller::preview', '_format' => 'html'], ['code', '_format'], null, null, false, true, null]],
        58 => [[['_route' => 'orders_update_status', '_controller' => 'App\\Controller\\OrdersController::updateStatus'], ['id'], ['PUT' => 0], null, false, true, null]],
        87 => [
            [['_route' => 'user_orders', '_controller' => 'App\\Controller\\UsersController::getUserOrders'], ['id'], ['GET' => 0], null, false, false, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
