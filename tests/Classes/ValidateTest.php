<?php

namespace Danupe\Plugin\User\Tests\Classes;

use Danupe\Plugin\User\Classes\Validate;
use PHPUnit\Framework\TestCase;

class ValidateTest extends TestCase
{
    private Validate $validator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->validator = new Validate();
    }

    public function testValidateRequiredFieldSuccess()
    {
        $data = ['name' => 'John'];
        $rules = ['name' => 'required'];
        
        // Mock the danupe session functions
        $this->mockDanupeSession();
        
        $result = Validate::validate($data, $rules);
        $this->assertTrue($result);
    }

    public function testValidateRequiredFieldFailure()
    {
        $data = ['name' => ''];
        $rules = ['name' => 'required'];
        
        $this->mockDanupeSession();
        
        $result = Validate::validate($data, $rules);
        $this->assertFalse($result);
    }

    public function testValidateEmailSuccess()
    {
        $data = ['email' => 'test@example.com'];
        $rules = ['email' => 'email'];
        
        $this->mockDanupeSession();
        
        $result = Validate::validate($data, $rules);
        $this->assertTrue($result);
    }

    public function testValidateEmailFailure()
    {
        $data = ['email' => 'invalid-email'];
        $rules = ['email' => 'email'];
        
        $this->mockDanupeSession();
        
        $result = Validate::validate($data, $rules);
        $this->assertFalse($result);
    }

    public function testValidateMinLengthSuccess()
    {
        $data = ['password' => 'password123'];
        $rules = ['password' => 'min:6'];
        
        $this->mockDanupeSession();
        
        $result = Validate::validate($data, $rules);
        $this->assertTrue($result);
    }

    public function testValidateMinLengthFailure()
    {
        $data = ['password' => '123'];
        $rules = ['password' => 'min:6'];
        
        $this->mockDanupeSession();
        
        $result = Validate::validate($data, $rules);
        $this->assertFalse($result);
    }

    public function testValidateMaxLengthSuccess()
    {
        $data = ['name' => 'John'];
        $rules = ['name' => 'max:10'];
        
        $this->mockDanupeSession();
        
        $result = Validate::validate($data, $rules);
        $this->assertTrue($result);
    }

    public function testValidateMaxLengthFailure()
    {
        $data = ['name' => 'Very Long Name That Exceeds Maximum'];
        $rules = ['name' => 'max:10'];
        
        $this->mockDanupeSession();
        
        $result = Validate::validate($data, $rules);
        $this->assertFalse($result);
    }

    public function testValidateSameFieldSuccess()
    {
        $data = ['password' => 'secret123', 'password_confirmation' => 'secret123'];
        $rules = ['password_confirmation' => 'same:password'];
        
        $this->mockDanupeSession();
        
        $result = Validate::validate($data, $rules);
        $this->assertTrue($result);
    }

    public function testValidateSameFieldFailure()
    {
        $data = ['password' => 'secret123', 'password_confirmation' => 'different'];
        $rules = ['password_confirmation' => 'same:password'];
        
        $this->mockDanupeSession();
        
        $result = Validate::validate($data, $rules);
        $this->assertFalse($result);
    }

    public function testValidateMultipleRulesSuccess()
    {
        $data = [
            'email' => 'test@example.com',
            'password' => 'password123',
            'name' => 'John'
        ];
        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:6',
            'name' => 'required|max:50'
        ];
        
        $this->mockDanupeSession();
        
        $result = Validate::validate($data, $rules);
        $this->assertTrue($result);
    }

    public function testValidateMultipleRulesFailure()
    {
        $data = [
            'email' => 'invalid-email',
            'password' => '123',
            'name' => ''
        ];
        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:6',
            'name' => 'required'
        ];
        
        $this->mockDanupeSession();
        
        $result = Validate::validate($data, $rules);
        $this->assertFalse($result);
    }

    private function mockDanupeSession()
    {
        // Since we can't easily mock danupe() function in unit tests,
        // these tests would need to be integration tests or we'd need
        // to refactor the Validate class to use dependency injection
        if (!function_exists('danupe')) {
            function danupe() {
                return new class {
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
