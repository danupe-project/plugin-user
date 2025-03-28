<?php

namespace Danupe\Plugin\User\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class HomeController
{

    public function login(Request $request, Response $response)
    {
        danupe()->view()->get('plugin-user','frontend/login', ['title' => 'Login']);
        return $response;
    }

    public function dashboard(Request $request, Response $response)
    {
        danupe()->view()->get('plugin-user','index', ['title' => 'Login']);
        return $response;
    }

}
