<?php

namespace Danupe\Plugin\User\Controllers;

use Danupe\Core\Classes\Controller;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class HomeController extends Controller
{

    public function login(Request $request, Response $response)
    {
        if (!danupe()->session()->has("user")) {
            danupe()->view()->get('plugin-user', 'frontend/login', ['title' => 'Login']);
            return $response;
        } else {
            $this->redirectWithSuccess('/' . $_ENV["DANUPE_ADMIN_PREFIX"] . '/dashboard', 'Hello again');
        }
    }

    public function dashboard(Request $request, Response $response)
    {
        danupe()->view()->get('plugin-user', 'index', ['title' => 'Login']);
        return $response;
    }
}
