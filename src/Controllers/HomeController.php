<?php

namespace Danupe\Plugin\User\Controllers;

use Danupe\Core\Classes\Controller;

class HomeController extends Controller
{

    public function login()
    {
        if (!danupe()->session()->has("user")) {
            danupe()->view()->get('plugin-user', 'frontend/login', ['title' => 'Login']);
        } else {
            $this->redirectWithSuccess('/' . $_ENV["DANUPE_ADMIN_PREFIX"] . '/dashboard', 'Hello again');
        }
    }

    public function dashboard()
    {
        danupe()->view()->get('plugin-user', 'index', ['title' => 'Login']);
    }
}
