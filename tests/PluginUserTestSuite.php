<?php

namespace Danupe\Plugin\User\Tests;

use PHPUnit\Framework\TestSuite;

/**
 * Test Suite für das Plugin User Package
 * 
 * Diese Test-Suite führt alle Tests für das plugin-user Package aus:
 * - Model Tests (User)
 * - Controller Tests (AuthController, HomeController, UserController)
 * - Class Tests (Admin, Form, Role, User, Validate)
 * - Middleware Tests (AuthMiddleware)
 */
class PluginUserTestSuite
{
    public static function suite()
    {
        $suite = new TestSuite('Plugin User Tests');
        
        // Model Tests
        $suite->addTestSuite('Danupe\Plugin\User\Tests\Models\UserTest');
        
        // Controller Tests
        $suite->addTestSuite('Danupe\Plugin\User\Tests\Controllers\AuthControllerTest');
        $suite->addTestSuite('Danupe\Plugin\User\Tests\Controllers\HomeControllerTest');
        $suite->addTestSuite('Danupe\Plugin\User\Tests\Controllers\UserControllerTest');
        
        // Class Tests
        $suite->addTestSuite('Danupe\Plugin\User\Tests\Classes\AdminTest');
        $suite->addTestSuite('Danupe\Plugin\User\Tests\Classes\FormTest');
        $suite->addTestSuite('Danupe\Plugin\User\Tests\Classes\RoleTest');
        $suite->addTestSuite('Danupe\Plugin\User\Tests\Classes\UserClassTest');
        $suite->addTestSuite('Danupe\Plugin\User\Tests\Classes\ValidateTest');
        
        // Middleware Tests
        $suite->addTestSuite('Danupe\Plugin\User\Tests\Middlewares\AuthMiddlewareTest');
        
        return $suite;
    }
}
