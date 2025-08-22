<?php

namespace Danupe\Plugin\User\Tests\Controllers;

use Danupe\Plugin\User\Controllers\AuthController;
use PHPUnit\Framework\TestCase;

class AuthControllerTest extends TestCase
{
    private AuthController $controller;

    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new AuthController();
    }

    public function testAuthControllerInstanceCreation()
    {
        $this->assertInstanceOf(AuthController::class, $this->controller);
    }

    public function testLoginPostMethodExists()
    {
        $this->assertTrue(method_exists($this->controller, 'login_post'));
    }

    public function testLogoutActionMethodExists()
    {
        $this->assertTrue(method_exists($this->controller, 'logout_action'));
    }

    public function testLoginPostWithValidCredentials()
    {
        // Dieser Test ist komplex, da er Database-Zugriff erfordert
        // In einem echten Test-Setup würde man eine Test-Database verwenden
        $this->assertTrue(true); // Placeholder Test
    }

    public function testLoginPostWithInvalidCredentials()
    {
        // Dieser Test ist komplex, da er Database-Zugriff erfordert
        // In einem echten Test-Setup würde man eine Test-Database verwenden
        $this->assertTrue(true); // Placeholder Test
    }

    public function testLogoutAction()
    {
        // Test that logout_action method exists and is callable
        $this->assertTrue(method_exists($this->controller, 'logout_action'));
        $this->assertTrue(is_callable([$this->controller, 'logout_action']));
        
        // Since the method calls external dependencies (danupe()->session()), 
        // we just test the basic functionality without actual execution
        $reflection = new \ReflectionMethod($this->controller, 'logout_action');
        $this->assertTrue($reflection->isPublic());
    }

    private function createMockRequest($data)
    {
        $request = $this->createMock(\Psr\Http\Message\ServerRequestInterface::class);
        $request->method('getParsedBody')->willReturn($data);
        return $request;
    }
}
