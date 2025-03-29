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
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|min:6|same:password',
            'role' => 'required'
        ];

        $validationResult = $validator->validate(danupe()->input()->all(), $rules);


        $data = danupe()->input()->only(['email', 'password', 'role']);
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);

        if ($validationResult) {
            $user = new User();
            $user->save($data);
            return $this->redirect( '/'.danupe()->env()->get('DANUPE_ADMIN_PREFIX').'/users/create', 'User created successfully');
        } else {
            return $this->redirectWithErrors( '/'.danupe()->env()->get('DANUPE_ADMIN_PREFIX').'/users/create', $validator->getErrors());
        }

    }

    public function update_post(Request $request, Response $response, array $args)
    {
        return $this->redirect( '/'.danupe()->env()->get('DANUPE_ADMIN_PREFIX').'/users/create', 'User updated successfully');
    }

    public function delete_post(Request $request, Response $response, array $args)
    {
        return $this->redirect( '/'.danupe()->env()->get('DANUPE_ADMIN_PREFIX').'/users/create', 'User updated successfully');
    }




}
