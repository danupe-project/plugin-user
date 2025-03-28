<?php

namespace Danupe\Plugin\User\Middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class AuthMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
    
        if (empty($_SESSION['user'])) {

            $response = new \Slim\Psr7\Response();
            danupe()->view()->get('plugin-user','frontend/403', ['title' => 'error 403']);
            return $response->withStatus(403);
        }
    
        return $handler->handle($request);
    }
}
