<?php

namespace Danupe\Plugin\User\Controllers;

use Danupe\Core\Classes\Controller;
use Danupe\Plugin\User\Classes\Validate;
use Danupe\Plugin\User\Models\User;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UserController extends Controller
{
    public function index($request, $response)
    {
        $users = new User();
        $users = $users->all();

        danupe()->view()->get('plugin-user', 'users/index', ['users' => $users, 'title' => 'user']);
        return $response;
    }

    public function table(Request $request, Response $response)
    {
        $total = danupe()->plugin('database', 'database')->table('users')->count();
        $users = new User();
        $data = $users->all();
        $this->json([
            'total' => $total,
            'data' => $data
        ]);
    }

    public function edit($request, $response, $args)
    {
        $user = new User();
        $user = $user->first(danupe()->data()->get($args, 'id'));
        danupe()->view()->get('plugin-user', 'users/edit', ['user' => $user, 'title' => 'edit']);
        return $response;
    }

    public function create(Request $request, Response $response)
    {
        danupe()->view()->get('plugin-user', 'users/create', ['title' => 'Create']);
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
            return $this->redirect('/' . danupe()->env()->get('DANUPE_ADMIN_PREFIX') . '/users/create', 'User created successfully');
        } else {
            return $this->redirectWithErrors('/' . danupe()->env()->get('DANUPE_ADMIN_PREFIX') . '/users/create', $validator->getErrors());
        }
    }

    public function update_post(Request $request, Response $response, array $args)
    {
        $validator = new Validate();

        $id = danupe()->input()->get('id');
        $rules = [];
        $password = false;
        if (danupe()->input()->get('password') && danupe()->input()->get('password_confirmation')) {
            $password = true;
            $rules = [
                'password' => 'required|min:6',
                'password_confirmation' => 'required|min:6|same:password',
            ];
        }

        $rules = array_merge($rules, [
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required'
        ]);

        $validationResult = $validator->validate(danupe()->input()->all(), $rules);

        if ($password) {
            $data = danupe()->input()->only(['email', 'password', 'role']);
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        } else {
            $data = danupe()->input()->only(['email', 'role', 'id']);
        }

        if ($validationResult) {
            $user = new User();
            $user->update($data);
            return $this->redirectWithSuccess('/' . danupe()->env()->get('DANUPE_ADMIN_PREFIX') . '/users/edit/' . $id, 'User updated successfully');
        } else {
            return $this->redirectWithErrors('/' . danupe()->env()->get('DANUPE_ADMIN_PREFIX') . '/users/edit/' . $id, $validator->getErrors());
        }
    }

    public function delete_post(Request $request, Response $response, array $args)
    {
        return $this->redirect('/' . danupe()->env()->get('DANUPE_ADMIN_PREFIX') . '/users/create');
    }
}
