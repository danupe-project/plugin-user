<?php

namespace Danupe\Plugin\User\Controllers;

use Danupe\Core\Classes\Controller;
use Danupe\Plugin\Database\Classes\Database;

class AuthController extends Controller
{
    public function login_post($request)
    {
        $data = $request->getParsedBody();

        $database = new Database();
        $email = filter_var(danupe()->data()->get($data, 'email'), FILTER_SANITIZE_EMAIL);
        $user = $database->table('users')->where(['email' => $email])->first();

        if ($user && password_verify($data['password'], danupe()->data()->get($user, 'password'))) {
            danupe()->session()->set('user',$user);
            $this->redirectWithSuccess('/' . $_ENV["DANUPE_ADMIN_PREFIX"] . '/dashboard','Hello');
        } else {
            return $this->redirectWithErrors('/login', 'Invalid email or password');
        }
    }

    public function logout_action()
    {
        danupe()->session()->destroy();
        return $this->redirectWithSuccess('/', 'logged out successfully');
    }
}
