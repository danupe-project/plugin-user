<?php

namespace Danupe\Plugin\User\Middlewares;

use Danupe\Core\Classes\Request;

class AuthMiddleware
{
    public function __invoke(Request $request, callable $next)
    {
        if (empty(danupe()->session()->get('user'))) {
            danupe()->view()->get('plugin-user', 'frontend/403', ['title' => 'error 403']);
            exit;
        }
        $next($request);
    }
}
