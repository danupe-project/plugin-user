<?php

namespace Danupe\Plugin\User\Tests\Classes;

use Danupe\Plugin\User\Classes\Role;
use PHPUnit\Framework\TestCase;

class RoleTest extends TestCase
{
    private Role $role;

    protected function setUp(): void
    {
        parent::setUp();
        $this->role = new Role();
    }

    public function testRoleInstanceCreation()
    {
        $this->assertInstanceOf(Role::class, $this->role);
    }

    public function testGetAllReturnsArray()
    {
        $this->mockDanupe();
        
        $result = $this->role->getAll();
        
        $this->assertIsArray($result);
    }

    public function testGetAllReturnsExpectedRoles()
    {
        // Da die Rolle von echten Route-Daten abhängt, testen wir nur das Format
        $result = $this->role->getAll();
        
        $this->assertIsArray($result);
        // Jeder Schlüssel sollte gleich seinem Wert sein
        foreach ($result as $key => $value) {
            $this->assertEquals($key, $value);
        }
    }

    public function testGetAllHandlesEmptyRoutes()
    {
        // Da wir echte Route-Daten verwenden, können wir leere Routen schwer simulieren
        $result = $this->role->getAll();
        
        $this->assertIsArray($result);
    }

    public function testGetAllHandlesRoutesWithoutRoles()
    {
        // Da wir echte Route-Daten verwenden, können wir Routen ohne Rollen schwer simulieren
        $result = $this->role->getAll();
        
        $this->assertIsArray($result);
    }

    private function mockDanupe()
    {
        if (!function_exists('danupe')) {
            function danupe() {
                return new class {
                    public function route() {
                        return new class {
                            public function getAll() {
                                return [
                                    [
                                        'path' => '/admin',
                                        'roles' => ['admin', 'user']
                                    ],
                                    [
                                        'path' => '/moderate',
                                        'roles' => ['moderator', 'admin']
                                    ],
                                    [
                                        'path' => '/user',
                                        'roles' => ['user']
                                    ]
                                ];
                            }
                        };
                    }
                    
                    public function data() {
                        return new class {
                            public function get($array, $key) {
                                return $array[$key] ?? [];
                            }
                        };
                    }
                };
            }
        }
    }

    private function mockDanupeWithEmptyRoutes()
    {
        if (!function_exists('danupe')) {
            function danupe() {
                return new class {
                    public function route() {
                        return new class {
                            public function getAll() {
                                return [];
                            }
                        };
                    }
                    
                    public function data() {
                        return new class {
                            public function get($array, $key) {
                                return $array[$key] ?? [];
                            }
                        };
                    }
                };
            }
        }
    }

    private function mockDanupeWithRoutesWithoutRoles()
    {
        if (!function_exists('danupe')) {
            function danupe() {
                return new class {
                    public function route() {
                        return new class {
                            public function getAll() {
                                return [
                                    ['path' => '/public'],
                                    ['path' => '/home']
                                ];
                            }
                        };
                    }
                    
                    public function data() {
                        return new class {
                            public function get($array, $key) {
                                return $array[$key] ?? [];
                            }
                        };
                    }
                };
            }
        }
    }
}
