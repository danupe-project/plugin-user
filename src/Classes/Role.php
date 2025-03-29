<?php

namespace Danupe\Plugin\User\Classes;

class Role
{
    public function getAll()
    {
        $roles = [];
        foreach (danupe()->route()->getAll() as $route) {
            $routeRoles = danupe()->data()->get($route, 'roles');
            foreach ($routeRoles as $role) {
                $roles[$role] = $role;
            }
        }
        return $roles;
    }
}
