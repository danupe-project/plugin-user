<?php

namespace Danupe\Plugin\User\Tests\Classes;

use Danupe\Plugin\User\Classes\Admin;
use PHPUnit\Framework\TestCase;

class AdminTest extends TestCase
{
    private Admin $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = new Admin();
    }

    public function testAdminInstanceCreation()
    {
        $this->assertInstanceOf(Admin::class, $this->admin);
    }

    public function testGetPrefix()
    {
        // Mock the danupe() function
        $this->mockDanupe();
        
        $result = $this->admin->getPrefix();
        
        $this->assertEquals('admin', $result);
    }

    public function testGetPrefixReturnsString()
    {
        $this->mockDanupe();
        
        $result = $this->admin->getPrefix();
        
        $this->assertIsString($result);
    }

    private function mockDanupe()
    {
        if (!function_exists('danupe')) {
            function danupe() {
                return new class {
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
                };
            }
        }
    }
}
