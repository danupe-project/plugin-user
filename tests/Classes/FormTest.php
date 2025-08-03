<?php

namespace Danupe\Plugin\User\Tests\Classes;

use Danupe\Plugin\User\Classes\Form;
use PHPUnit\Framework\TestCase;

class FormTest extends TestCase
{
    public function testInputBasic()
    {
        $result = Form::input('username', 'text', 'john_doe');
        
        $this->assertStringContainsString('type="text"', $result);
        $this->assertStringContainsString('name="username"', $result);
        $this->assertStringContainsString('value="john_doe"', $result);
        $this->assertStringContainsString('class=" border rounded px-4 py-2 w-full"', $result);
    }

    public function testInputWithCustomAttributes()
    {
        $attributes = ['class' => 'custom-class', 'id' => 'username-input'];
        $result = Form::input('username', 'text', 'john_doe', $attributes);
        
        $this->assertStringContainsString('class="custom-class border rounded px-4 py-2 w-full"', $result);
        $this->assertStringContainsString('id="username-input"', $result);
    }

    public function testPasswordField()
    {
        $result = Form::password('password', 'password', 'secret');
        
        $this->assertStringContainsString('type="password"', $result);
        $this->assertStringContainsString('name="password"', $result);
        $this->assertStringContainsString('value="secret"', $result);
        $this->assertStringContainsString('class=" border rounded px-4 py-2 w-full"', $result);
    }

    public function testTextarea()
    {
        $result = Form::textarea('description', 'This is a description');
        
        $this->assertStringContainsString('<textarea', $result);
        $this->assertStringContainsString('name="description"', $result);
        $this->assertStringContainsString('>This is a description</textarea>', $result);
        $this->assertStringContainsString('class=" border rounded px-4 py-2 w-full"', $result);
    }

    public function testSelect()
    {
        $options = ['1' => 'Option 1', '2' => 'Option 2', '3' => 'Option 3'];
        $result = Form::select('choice', $options, '2');
        
        $this->assertStringContainsString('<select', $result);
        $this->assertStringContainsString('name="choice"', $result);
        $this->assertStringContainsString('<option value="1" >Option 1</option>', $result);
        $this->assertStringContainsString('<option value="2" selected>Option 2</option>', $result);
        $this->assertStringContainsString('<option value="3" >Option 3</option>', $result);
    }

    public function testSelectWithoutSelected()
    {
        $options = ['1' => 'Option 1', '2' => 'Option 2'];
        $result = Form::select('choice', $options);
        
        $this->assertStringContainsString('<option value="1" >Option 1</option>', $result);
        $this->assertStringContainsString('<option value="2" >Option 2</option>', $result);
        $this->assertStringNotContainsString('selected', $result);
    }

    public function testCheckboxChecked()
    {
        $result = Form::checkbox('agree', '1', true);
        
        $this->assertStringContainsString('type="checkbox"', $result);
        $this->assertStringContainsString('name="agree"', $result);
        $this->assertStringContainsString('value="1"', $result);
        $this->assertStringContainsString('checked', $result);
    }

    public function testCheckboxUnchecked()
    {
        $result = Form::checkbox('agree', '1', false);
        
        $this->assertStringContainsString('type="checkbox"', $result);
        $this->assertStringContainsString('name="agree"', $result);
        $this->assertStringContainsString('value="1"', $result);
        $this->assertStringNotContainsString('checked', $result);
    }

    public function testSubmitButton()
    {
        $result = Form::submit('Save Changes');
        
        $this->assertStringContainsString('<button', $result);
        $this->assertStringContainsString('type="submit"', $result);
        $this->assertStringContainsString('>Save Changes</button>', $result);
        $this->assertStringContainsString('class="btn btn-solid-primary"', $result);
    }

    public function testSubmitButtonWithCustomClass()
    {
        $attributes = ['class' => 'custom-btn'];
        $result = Form::submit('Submit', $attributes);
        
        $this->assertStringContainsString('class="custom-btn"', $result);
    }

    public function testFileInput()
    {
        $result = Form::file('upload');
        
        $this->assertStringContainsString('type="file"', $result);
        $this->assertStringContainsString('name="upload"', $result);
        $this->assertStringContainsString('class=" border rounded px-4 py-2 w-full"', $result);
    }

    public function testLabel()
    {
        $result = Form::label('username', 'Username');
        
        $this->assertStringContainsString('<label', $result);
        $this->assertStringContainsString('for="username"', $result);
        $this->assertStringContainsString('>Username</label>', $result);
        $this->assertStringContainsString('class=" font-bold text-gray-700"', $result);
    }

    public function testCsrfToken()
    {
        // Mock the danupe session function
        $this->mockDanupe();
        
        $result = Form::csrf();
        
        $this->assertStringContainsString('type="hidden"', $result);
        $this->assertStringContainsString('name="csrf_token"', $result);
    }

    public function testCsrfTokenWithCustomToken()
    {
        $result = Form::csrf('custom-token-123');
        
        $this->assertStringContainsString('type="hidden"', $result);
        $this->assertStringContainsString('name="csrf_token"', $result);
        $this->assertStringContainsString('value="custom-token-123"', $result);
    }

    public function testWysiwygEditor()
    {
        $result = Form::wysiwyg('content', 'Initial content');
        
        $this->assertStringContainsString('x-data=', $result);
        $this->assertStringContainsString('name="content"', $result);
        $this->assertStringContainsString('Initial content', $result);
        $this->assertStringContainsString('wysiwyg-editor', $result);
    }

    public function testBuildAttributesMethod()
    {
        $reflection = new \ReflectionClass(Form::class);
        $method = $reflection->getMethod('buildAttributes');
        $method->setAccessible(true);
        
        $attributes = ['class' => 'test-class', 'id' => 'test-id', 'data-value' => 'test'];
        $result = $method->invoke(null, $attributes);
        
        $this->assertStringContainsString('class="test-class"', $result);
        $this->assertStringContainsString('id="test-id"', $result);
        $this->assertStringContainsString('data-value="test"', $result);
    }

    private function mockDanupe()
    {
        if (!function_exists('danupe')) {
            function danupe() {
                return new class {
                    public function session() {
                        return new class {
                            public function get($key) {
                                if ($key === 'csrf_token') {
                                    return 'mocked-csrf-token';
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
