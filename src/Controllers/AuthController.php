<?php

namespace Danupe\Plugin\User\Controllers;

use Danupe\Core\Classes\Controller;
use Danupe\Plugin\Database\Classes\Database;
use PDO;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AuthController extends Controller
{
    public function login_post(Request $request, Response $response)
    {
        $data = $request->getParsedBody();

        $database = new Database();
        $user = $database->table('users')->where(['email'=> danupe()->data()->get($data,'email')])->first();

        if ($user && password_verify($data['password'], danupe()->data()->get($user, 'password'))) {
            danupe()->session()->set('user',$user);
            $this->redirectWithSuccess('/' . $_ENV["DANUPE_ADMIN_PREFIX"] . '/dashboard','Hello');
        } else {
            return $this->redirectWithErrors('/login', 'Invalid email or password');
        }
    }

    public function logout_action(Request $request, Response $response)
    {
        session_destroy();
        return $response->withHeader('Location', '/login')->withStatus(302);
    }
}
