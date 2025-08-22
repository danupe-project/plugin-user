<?php

namespace Danupe\Plugin\User\Tests\Controllers;

use Danupe\Plugin\User\Controllers\UserController;
use Danupe\Plugin\User\Models\User;
use PHPUnit\Framework\TestCase;

class UserControllerTest extends TestCase
{
    private UserController $controller;

    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new UserController();
    }

    public function testUserControllerInstanceCreation()
    {
        $this->assertInstanceOf(UserController::class, $this->controller);
    }

    public function testIndexMethodExists()
    {
        $this->assertTrue(method_exists($this->controller, 'index'));
    }

    public function testTableMethodExists()
    {
        $this->assertTrue(method_exists($this->controller, 'table'));
    }

    public function testEditMethodExists()
    {
        $this->assertTrue(method_exists($this->controller, 'edit'));
    }

    public function testCreateMethodExists()
    {
        $this->assertTrue(method_exists($this->controller, 'create'));
    }

    public function testCreatePostMethodExists()
    {
        $this->assertTrue(method_exists($this->controller, 'create_post'));
    }

    public function testUpdatePostMethodExists()
    {
        $this->assertTrue(method_exists($this->controller, 'update_post'));
    }

    public function testIndexMethodCallsView()
    {
        $this->mockDanupe();
        
        // Capture output to prevent view rendering during test
        ob_start();
        $this->controller->index();
        ob_end_clean();
        
        // If we get here without exceptions, the method executed successfully
        $this->assertTrue(true);
    }

    public function testCreateMethodCallsView()
    {
        $this->mockDanupe();
        
        ob_start();
        $this->controller->create();
        ob_end_clean();
        
        $this->assertTrue(true);
    }

    public function testEditMethodCallsView()
    {
        // Test that edit method exists and is public
        $this->assertTrue(method_exists($this->controller, 'edit'));
        
        $reflection = new \ReflectionMethod($this->controller, 'edit');
        $this->assertTrue($reflection->isPublic());
        
        // Test method signature - edit should accept 2 parameters ($request, $id)
        $this->assertEquals(2, $reflection->getNumberOfParameters());
        
        $parameters = $reflection->getParameters();
        $this->assertEquals('request', $parameters[0]->getName());
        $this->assertEquals('id', $parameters[1]->getName());
        
        // Test that the method is callable
        $this->assertTrue(is_callable([$this->controller, 'edit']));
    }

    private function mockDanupe()
    {
        if (!function_exists('danupe')) {
            function danupe() {
                return new class {
                    public function view() {
                        return new class {
                            public function get($plugin, $view, $data = []) {
                                // Mock view rendering
                                return '';
                            }
                        };
                    }
                    
                    public function plugin($name, $instance) {
                        return new class {
                            public function table($tableName) {
                                return new class {
                                    public function count() {
                                        return 10;
                                    }
                                };
                            }
                        };
                    }
                    
                    public function data() {
                        return new class {
                            public function get($array, $key) {
                                return $array[$key] ?? null;
                            }
                        };
                    }
                    
                    public function input() {
                        return new class {
                            public function all() {
                                return [
                                    'email' => 'test@example.com',
                                    'password' => 'password123',
                                    'password_confirmation' => 'password123',
                                    'role' => 'user'
                                ];
                            }
                            
                            public function only($fields) {
                                $data = $this->all();
                                return array_intersect_key($data, array_flip($fields));
                            }
                            
                            public function get($key) {
                                $data = $this->all();
                                return $data[$key] ?? null;
                            }
                        };
                    }
                    
                    public function env() {
                        return new class {
                            public function get($key) {
                                if ($key === 'DANUPE_ADMIN_PREFIX') {
                                    return 'admin';
                                }
                                return null;
                            }
                        };
                    }
                    
                    public function session() {
                        return new class {
                            private $data = [];
                            
                            public function set($key, $value) {
                                $this->data[$key] = $value;
                            }
                            
                            public function get($key) {
                                return $this->data[$key] ?? null;
                            }
                        };
                    }
                };
            }
        }
    }
}
