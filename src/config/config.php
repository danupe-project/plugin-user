<?php

$prefix = danupe()->plugin('user', 'admin')->getPrefix();
return [
    'middlewares' => [
        'auth' => 'Danupe\Plugin\User\Middlewares\AuthMiddleware',
    ],

    'navigation' => [
        '/' . $prefix . '/dashboard' => ['title' => 'Dashboard', 'icon' => 'fa fa-home', 'sort' => 100, 'parent' => ''],
        '/' . $prefix . '/profile' => ['title' => 'Profile', 'icon' => 'fa fa-user', 'sort' => 101, 'parent' => ''],
        '/' . $prefix . '/users' => ['title' => 'Users', 'icon' => 'fa fa-users', 'sort' => 102, 'parent' => ''],
        '/' . $prefix . '/users/create' => ['title' => 'Users create', 'icon' => 'fa fa-users', 'sort' => 1, 'parent' => '/users'],
    ],
    'routes' => [
        '/login' => [
            'controller' => 'Danupe\Plugin\User\Controllers\HomeController',
            'action' => 'login',
            'method' => 'GET',
            'middlewares' => [],
            'roles' => ['guest'],
        ],
        '/logout' => [
            'controller' => 'Danupe\Plugin\User\Controllers\AuthController',
            'action' => 'logout_action',
            'method' => 'GET',
            'middlewares' => ['auth'],
            'roles' => ['user', 'admin'],
        ],
        '/' . $prefix . '/js/littleBigTable.js' => [
            'controller' => 'Danupe\Core\Classes\AssetController',
            'action' => 'load',
            'method' => 'GET',
            'middlewares' => [],
            'roles' => ['guest'],
            'path' => danupe()->path()->plugin('plugin-user') . '/src/views/assets/js/littleBigTable.js',
            'type' => 'javascript',
        ],
        '/' . $prefix . '/login_post' => [
            'controller' => 'Danupe\Plugin\User\Controllers\AuthController',
            'action' => 'login_post',
            'method' => 'POST',
            'middlewares' => [],
            'roles' => ['guest'],
        ],
        '/' . $prefix . '/dashboard' => [
            'controller' => 'Danupe\Plugin\User\Controllers\HomeController',
            'action' => 'dashboard',
            'method' => 'GET',
            'middlewares' => ['auth'],
            'roles' => ['editor', 'user', 'admin'],
        ],
        '/' . $prefix . '/users' => [
            'controller' => 'Danupe\Plugin\User\Controllers\UserController',
            'action' => 'index',
            'middlewares' => ['auth'],
            'method' => 'GET',
            'roles' => ['user', 'admin'],
        ],
        '/' . $prefix . '/users/table' => [
            'controller' => 'Danupe\Plugin\User\Controllers\UserController',
            'action' => 'table',
            'middlewares' => ['auth'],
            'method' => 'GET',
            'roles' => ['user', 'admin'],
        ],
        '/' . $prefix . '/users/create' => [
            'controller' => 'Danupe\Plugin\User\Controllers\UserController',
            'action' => 'create',
            'middlewares' => ['auth'],
            'method' => 'GET',
            'roles' => ['user', 'admin'],
        ],
        '/' . $prefix . '/users/edit/{id}' => [
            'controller' => 'Danupe\Plugin\User\Controllers\UserController',
            'action' => 'edit',
            'middlewares' => ['auth'],
            'method' => 'GET',
            'roles' => ['user', 'admin'],
        ],
        '/' . $prefix . '/users/create_post' => [
            'controller' => 'Danupe\Plugin\User\Controllers\UserController',
            'action' => 'create_post',
            'middlewares' => ['auth'],
            'method' => 'POST',
            'roles' => ['user', 'admin'],
        ],
        '/' . $prefix . '/users/update_post' => [
            'controller' => 'Danupe\Plugin\User\Controllers\UserController',
            'action' => 'update_post',
            'middlewares' => ['auth'],
            'method' => 'POST',
            'roles' => ['user', 'admin'],
        ],
        '/' . $prefix . '/users/delete_post' => [
            'controller' => 'Danupe\Plugin\User\Controllers\UserController',
            'action' => 'delete_post',
            'middlewares' => ['auth'],
            'method' => 'POST',
            'roles' => ['user', 'admin'],
        ],
    ],
];
