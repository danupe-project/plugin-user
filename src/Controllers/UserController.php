<?php

namespace Danupe\Plugin\User\Controllers;

use Danupe\Core\Classes\Controller;
use Danupe\Plugin\User\Classes\Validate;
use Danupe\Plugin\User\Models\User;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UserController extends Controller
{
    public function index()
    {
        $users = (new User())->all(['id','email','role']);

        danupe()->view()->get('plugin-user', 'users/index', [
            'users' => $users,
            'title' => 'Users'
        ]);
    }

    public function table()
    {
        $db = danupe()->plugin('database','database')->table('users');
        $limit = (int) danupe()->input()->get('limit', 10);
        $offset = (int) danupe()->input()->get('offset', 0);
        $search = trim((string) danupe()->input()->get('search', ''));
        $sort = (string) danupe()->input()->get('sort', '');
        
        // Apply search filter
        if ($search !== '') { 
            $like = '%'.$search.'%'; 
            $db->whereRaw('(`email` LIKE :s1 OR `role` LIKE :s2)', ['s1'=>$like,'s2'=>$like]); 
        }
        
        // Get total count for pagination
        $total = $db->count();
        
        // Apply sorting
        if ($sort) {
            [$column, $direction] = array_pad(explode(':', $sort), 2, 'asc');
            $allowedColumns = ['id', 'email', 'role'];
            if (in_array($column, $allowedColumns)) {
                $direction = strtolower($direction) === 'dsc' ? 'desc' : 'asc';
                $db->orderBy([$column => $direction]);
            }
        } else {
            $db->orderBy(['id' => 'asc']);
        }
        
        // Get paginated results
        $rows = $db->offset($offset)->limit($limit)->get();
        $data = array_map(fn($r) => [
            'id' => $r['id'],
            'email' => $r['email'],
            'role' => $r['role']
        ], $rows);
        
        $this->json(['total' => $total, 'data' => $data]);
    }

    public function edit($request, $id)
    {
        $userModel = new User();

        if (empty($id)) {
            return $this->redirectWithErrors('/' . danupe()->env()->get('DANUPE_ADMIN_PREFIX') . '/users', 'User ID missing');
        }

        try {
            $user = $userModel->first($id);
        } catch (\Exception $e) {
            return $this->redirectWithErrors('/' . danupe()->env()->get('DANUPE_ADMIN_PREFIX') . '/users', 'User not found');
        }

        danupe()->view()->get('plugin-user', 'users/edit', [
            'user' => $user,
            'title' => 'Edit User'
        ]);
    }

    public function create()
    {
        danupe()->view()->get('plugin-user', 'users/create', ['title' => 'Create User']);
    }

    public function create_post()
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
            (new User())->save($data);
            return $this->redirectWithSuccess('/' . danupe()->env()->get('DANUPE_ADMIN_PREFIX') . '/users/create', 'User created successfully');
        }
        return $this->redirectWithErrors('/' . danupe()->env()->get('DANUPE_ADMIN_PREFIX') . '/users/create', $validator->getErrors());
    }

    public function update_post()
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
            $data = danupe()->input()->only(['email', 'password', 'role','id']);
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        } else {
            $data = danupe()->input()->only(['email', 'role', 'id']);
        }
        if ($validationResult) {
            (new User())->update($data);
            return $this->redirectWithSuccess('/' . danupe()->env()->get('DANUPE_ADMIN_PREFIX') . '/users/edit/' . $id, 'User updated successfully');
        }
        return $this->redirectWithErrors('/' . danupe()->env()->get('DANUPE_ADMIN_PREFIX') . '/users/edit/' . $id, $validator->getErrors());
    }

    public function delete_post()
    {
        $validator = new Validate();
        $rules = [ 'id' => 'required|integer' ];
        $payload = danupe()->input()->only(['id']);
        $validationResult = $validator->validate($payload, $rules);
        $id = danupe()->data()->get($payload, 'id');
        $prefix = danupe()->env()->get('DANUPE_ADMIN_PREFIX');
        if ($validationResult) {
            try {
                $currentUser = danupe()->auth()->user();
                if ($currentUser && (int) danupe()->data()->get($currentUser, 'id') === (int) $id) {
                    return $this->redirectWithErrors('/' . $prefix . '/users/edit/' . $id, 'You cannot delete your own user while logged in.');
                }
            } catch (\Throwable $t) {
                // ignore auth errors
            }
            try {
                (new User())->delete($id);
            } catch (\Throwable $e) {
                return $this->redirectWithErrors('/' . $prefix . '/users/edit/' . $id, 'User could not be deleted.');
            }
            return $this->redirectWithSuccess('/' . $prefix . '/users', 'User deleted successfully');
        }
        return $this->redirectWithErrors('/' . $prefix . '/users/edit/' . $id, $validator->getErrors());
    }
}
