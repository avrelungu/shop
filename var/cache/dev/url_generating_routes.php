<?php

// This file has been auto-generated by the Symfony Routing Component.

return [
    '_preview_error' => [['code', '_format'], ['_controller' => 'error_controller::preview', '_format' => 'html'], ['code' => '\\d+'], [['variable', '.', '[^/]++', '_format', true], ['variable', '/', '\\d+', 'code', true], ['text', '/_error']], [], [], []],
    'orders_create' => [[], ['_controller' => 'App\\Controller\\OrdersController::create'], [], [['text', '/orders']], [], [], []],
    'orders_update_status' => [['id'], ['_controller' => 'App\\Controller\\OrdersController::updateStatus'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/orders']], [], [], []],
    'ping' => [[], ['_controller' => 'App\\Controller\\PingController::index'], [], [['text', '/']], [], [], []],
    'user_orders' => [['id'], ['_controller' => 'App\\Controller\\UsersController::getUserOrders'], [], [['text', '/orders'], ['variable', '/', '[^/]++', 'id', true], ['text', '/users']], [], [], []],
    'user_create' => [[], ['_controller' => 'App\\Controller\\UsersController::store'], [], [['text', '/users']], [], [], []],
    'App\Controller\OrdersController::create' => [[], ['_controller' => 'App\\Controller\\OrdersController::create'], [], [['text', '/orders']], [], [], []],
    'App\Controller\OrdersController::updateStatus' => [['id'], ['_controller' => 'App\\Controller\\OrdersController::updateStatus'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/orders']], [], [], []],
    'App\Controller\PingController::index' => [[], ['_controller' => 'App\\Controller\\PingController::index'], [], [['text', '/']], [], [], []],
    'App\Controller\UsersController::getUserOrders' => [['id'], ['_controller' => 'App\\Controller\\UsersController::getUserOrders'], [], [['text', '/orders'], ['variable', '/', '[^/]++', 'id', true], ['text', '/users']], [], [], []],
    'App\Controller\UsersController::store' => [[], ['_controller' => 'App\\Controller\\UsersController::store'], [], [['text', '/users']], [], [], []],
];
