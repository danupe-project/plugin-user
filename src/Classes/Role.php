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

    public function isAllowed(?string $currentRole, ?array $allowedRoles): bool
    {
        if (empty($allowedRoles)) {
            return true;
        }

        $currentRole = $currentRole ?: 'guest';
        if ($currentRole === 'admin') {
            return true;
        }

        $mapping = [
            'user'   => ['user', 'editor', 'guest'], // User sieht User + Editor
            'editor' => ['editor', 'guest'],         // Editor sieht nur Editor
            'guest'  => ['guest'],                   // Guest sieht nur Guest
        ];

        $accessibleRoles = $mapping[$currentRole] ?? [$currentRole];

        foreach ($allowedRoles as $role) {
            if (in_array($role, $accessibleRoles)) {
                return true;
            }
        }

        return false;
    }
}
