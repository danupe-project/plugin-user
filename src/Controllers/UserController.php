<?php

namespace Danupe\Plugin\User\Controllers;

use Danupe\Core\Classes\Controller;
use Danupe\Plugin\User\Classes\Validate;
use Danupe\Plugin\User\Models\User;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UserController extends Controller
{

    public function create(Request $request, Response $response)
    {
        danupe()->view()->get('plugin-user','users/create', ['title' => 'Create']);
        return $response;
    }

    public function create_post(Request $request, Response $response)
    {

        $validator = new Validate();
        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|min:6|same:password',
            'role_id' => 'required'
        ];

        $validationResult = $validator->validate(danupe()->input()->all(), $rules);

        if ($validationResult) {
            $user = new User();
            $user->save(danupe()->input()->all());
        } else {
            return $this->redirectWithErrors( '/'.danupe()->env()->get('DANUPE_ADMIN_PREFIX').'/users/create', $validator->getErrors());
        }

    }

    public function update_post(Request $request, Response $response, array $args)
    {
        $postId = $args['id'] ?? null;
        $data = $request->getParsedBody();
        // return $response->withJson(['message' => 'Post updated successfully']);
    }

    public function delete_post(Request $request, Response $response, array $args)
    {
        $postId = $args['id'] ?? null;
        // return $response->withJson(['message' => 'Post deleted successfully']);
    }




}
