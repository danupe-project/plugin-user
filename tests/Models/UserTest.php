<?php

namespace Danupe\Plugin\User\Tests\Models;

use Danupe\Plugin\User\Models\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = new User();
    }

    public function testUserInstanceCreation()
    {
        $this->assertInstanceOf(User::class, $this->user);
    }

    public function testUserTableName()
    {
        $reflection = new \ReflectionClass($this->user);
        $tableProperty = $reflection->getProperty('table');
        $tableProperty->setAccessible(true);
        
        $this->assertEquals('users', $tableProperty->getValue($this->user));
    }

    public function testUserAttributes()
    {
        // Da der Model Constructor die attributes überschreibt, testen wir mit vorgegebenen Daten
        $testData = [
            'id' => 1,
            'email' => 'test@example.com',
            'password' => 'hashedpassword'
        ];
        
        $user = new User($testData);
        $reflection = new \ReflectionClass($user);
        $attributesProperty = $reflection->getProperty('attributes');
        $attributesProperty->setAccessible(true);
        $attributes = $attributesProperty->getValue($user);
        
        $this->assertEquals($testData, $attributes);
    }

    public function testUserHasId()
    {
        $testData = ['id' => 1, 'email' => 'test@example.com', 'password' => 'hashedpassword'];
        $user = new User($testData);
        
        $reflection = new \ReflectionClass($user);
        $attributesProperty = $reflection->getProperty('attributes');
        $attributesProperty->setAccessible(true);
        $attributes = $attributesProperty->getValue($user);
        
        $this->assertArrayHasKey('id', $attributes);
    }

    public function testUserHasEmail()
    {
        $testData = ['id' => 1, 'email' => 'test@example.com', 'password' => 'hashedpassword'];
        $user = new User($testData);
        
        $reflection = new \ReflectionClass($user);
        $attributesProperty = $reflection->getProperty('attributes');
        $attributesProperty->setAccessible(true);
        $attributes = $attributesProperty->getValue($user);
        
        $this->assertArrayHasKey('email', $attributes);
    }

    public function testUserHasPassword()
    {
        $testData = ['id' => 1, 'email' => 'test@example.com', 'password' => 'hashedpassword'];
        $user = new User($testData);
        
        $reflection = new \ReflectionClass($user);
        $attributesProperty = $reflection->getProperty('attributes');
        $attributesProperty->setAccessible(true);
        $attributes = $attributesProperty->getValue($user);
        
        $this->assertArrayHasKey('password', $attributes);
    }

    public function testGetAttribute()
    {
        $testData = ['id' => 1, 'email' => 'test@example.com', 'password' => 'hashedpassword'];
        $user = new User($testData);
        
        $this->assertEquals(1, $user->getAttribute('id'));
        $this->assertEquals('test@example.com', $user->getAttribute('email'));
        $this->assertEquals('hashedpassword', $user->getAttribute('password'));
        $this->assertNull($user->getAttribute('nonexistent'));
    }

    public function testSetAttribute()
    {
        $user = new User();
        
        $user->setAttribute('email', 'new@example.com');
        $this->assertEquals('new@example.com', $user->getAttribute('email'));
        
        $user->setAttribute('id', 42);
        $this->assertEquals(42, $user->getAttribute('id'));
    }
}
