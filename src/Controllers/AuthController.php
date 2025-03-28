<?php

namespace Danupe\Plugin\User\Controllers;

use Danupe\Plugin\Database\Classes\Database;
use PDO;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AuthController
{
    public function login_post(Request $request, Response $response)
    {
        $data = $request->getParsedBody();

        $database = new Database();
        $user = $database->table('users')->where(['email' => danupe()->data()->get($data,'email')])->first();

        if ($user && password_verify($data['password'], danupe()->data()->get($user, 'password'))) {
            $_SESSION['user'] = $user;
            return $response->withHeader('Location', '/' . $_ENV["DANUPE_ADMIN_PREFIX"] . '/dashboard')->withStatus(302);
        } else {
            $response->getBody()->write('Login fehlgeschlagen');
            return $response->withStatus(401);
        }
    }

    public function logout_action(Request $request, Response $response)
    {
        session_destroy();
        return $response->withHeader('Location', '/')->withStatus(302);
    }
}
