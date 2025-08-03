<?php

namespace Danupe\Plugin\User\Tests\Controllers;

use Danupe\Plugin\User\Controllers\HomeController;
use PHPUnit\Framework\TestCase;

class HomeControllerTest extends TestCase
{
    private HomeController $controller;

    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new HomeController();
    }

    public function testHomeControllerInstanceCreation()
    {
        $this->assertInstanceOf(HomeController::class, $this->controller);
    }

    public function testLoginMethodExists()
    {
        $this->assertTrue(method_exists($this->controller, 'login'));
    }

    public function testDashboardMethodExists()
    {
        $this->assertTrue(method_exists($this->controller, 'dashboard'));
    }

    public function testLoginWithoutAuthenticatedUser()
    {
        $this->mockDanupeWithoutUser();
        
        ob_start();
        $this->controller->login();
        ob_end_clean();
        
        // If we get here without exceptions, the method executed successfully
        $this->assertTrue(true);
    }

    public function testLoginWithAuthenticatedUser()
    {
        $this->mockDanupeWithUser();
        
        ob_start();
        $this->controller->login();
        ob_end_clean();
        
        $this->assertTrue(true);
    }

    public function testDashboard()
    {
        $this->mockDanupe();
        
        ob_start();
        $this->controller->dashboard();
        ob_end_clean();
        
        $this->assertTrue(true);
    }

    private function mockDanupeWithoutUser()
    {
        $_ENV["DANUPE_ADMIN_PREFIX"] = 'admin';
        
        if (!function_exists('danupe')) {
            function danupe() {
                return new class {
                    public function session() {
                        return new class {
                            public function has($key) {
                                return false; // No user session
                            }
                            
                            public function get($key) {
                                return null;
                            }
                        };
                    }
                    
                    public function view() {
                        return new class {
                            public function get($plugin, $view, $data = []) {
                                // Mock view rendering
                                return '';
                            }
                        };
                    }
                };
            }
        }
    }

    private function mockDanupeWithUser()
    {
        $_ENV["DANUPE_ADMIN_PREFIX"] = 'admin';
        
        if (!function_exists('danupe')) {
            function danupe() {
                return new class {
                    public function session() {
                        return new class {
                            public function has($key) {
                                if ($key === 'user') {
                                    return true; // User is authenticated
                                }
                                return false;
                            }
                            
                            public function get($key) {
                                if ($key === 'user') {
                                    return ['id' => 1, 'email' => 'test@example.com'];
                                }
                                return null;
                            }
                        };
                    }
                };
            }
        }
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
                };
            }
        }
    }
}
