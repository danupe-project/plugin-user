<?php

return [
    'middlewares' => [
        'auth' => 'Danupe\Plugin\User\Middlewares\AuthMiddleware',
    ],

    'navigation' => [
        '/' . $_ENV["DANUPE_ADMIN_PREFIX"] . '/dashboard' => ['title' => 'Dashboard', 'icon' => 'fa fa-home', 'sort' => 100, 'parent' => ''],
        '/' . $_ENV["DANUPE_ADMIN_PREFIX"] . '/profile' => ['title' => 'Profile', 'icon' => 'fa fa-user', 'sort' => 101, 'parent' => ''],
        '/' . $_ENV["DANUPE_ADMIN_PREFIX"] . '/users' => ['title' => 'Users', 'icon' => 'fa fa-users', 'sort' => 102, 'parent' => ''],
        '/' . $_ENV["DANUPE_ADMIN_PREFIX"] . '/users/create' => ['title' => 'Users create', 'icon' => 'fa fa-users', 'sort' => 1, 'parent' => '/users'],
    ],
    'routes' => [
        'guest' => [
            'GET' => [
                '/login' => [
                    'controller' => 'Danupe\Plugin\User\Controllers\HomeController',
                    'action' => 'login',
                ],
                '/' . $_ENV["DANUPE_ADMIN_PREFIX"] . '/logout' => [
                    'controller' => 'Danupe\Plugin\User\Controllers\AuthController',
                    'action' => 'logout_action',
                ]
            ],
            'POST' => [
                '/' . $_ENV["DANUPE_ADMIN_PREFIX"] . '/login_post' => [
                    'controller' => 'Danupe\Plugin\User\Controllers\AuthController',
                    'action' => 'login_post',
                ],
            ],
        ],
        'user' => [
            'GET' => [
                '/' . $_ENV["DANUPE_ADMIN_PREFIX"] . '/dashboard' => [
                    'controller' => 'Danupe\Plugin\User\Controllers\HomeController',
                    'action' => 'dashboard',
                    'middlewares' => ['auth'],
                ],
                '/' . $_ENV["DANUPE_ADMIN_PREFIX"] . '/users' => [
                    'controller' => 'Danupe\Plugin\User\Controllers\UserController',
                    'action' => 'index',
                    'middlewares' => ['auth'],
                ],
                '/' . $_ENV["DANUPE_ADMIN_PREFIX"] . '/users/create' => [
                    'controller' => 'Danupe\Plugin\User\Controllers\UserController',
                    'action' => 'create',
                    'middlewares' => ['auth'],
                ],
                '/' . $_ENV["DANUPE_ADMIN_PREFIX"] . '/users/edit/{id?}' => [
                    'controller' => 'Danupe\Plugin\User\Controllers\UserController',
                    'action' => 'edit',
                    'middlewares' => ['auth'],
                ],
            ],
            'POST' => [
                '/' . $_ENV["DANUPE_ADMIN_PREFIX"] . '/users/create_post' => [
                    'controller' => 'Danupe\Plugin\User\Controllers\UserController',
                    'action' => 'create_post',
                    'middlewares' => ['auth'],
                ],
                '/' . $_ENV["DANUPE_ADMIN_PREFIX"] . '/users/update_post' => [
                    'controller' => 'Danupe\Plugin\User\Controllers\UserController',
                    'action' => 'update_post',
                    'middlewares' => ['auth'],
                ],
                '/' . $_ENV["DANUPE_ADMIN_PREFIX"] . '/users/delete_post' => [
                    'controller' => 'Danupe\Plugin\User\Controllers\UserController',
                    'action' => 'delete_post',
                    'middlewares' => ['auth'],
                ],
            ],
        ],
    ],
];
