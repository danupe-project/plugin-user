<?php

namespace Danupe\Plugin\User\Tests\Classes;

use Danupe\Plugin\User\Classes\User;
use PHPUnit\Framework\TestCase;

class UserClassTest extends TestCase
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

    public function testUserConstructor()
    {
        // Test that the constructor doesn't throw any exceptions
        $user = new User();
        $this->assertInstanceOf(User::class, $user);
    }

    public function testUserIsInstantiable()
    {
        // Test multiple instantiations
        $user1 = new User();
        $user2 = new User();
        
        $this->assertInstanceOf(User::class, $user1);
        $this->assertInstanceOf(User::class, $user2);
        $this->assertNotSame($user1, $user2);
    }
}
