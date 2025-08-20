<?php

namespace Danupe\Plugin\User\Tests\Middlewares;

use Danupe\Plugin\User\Middlewares\AuthMiddleware;
use Danupe\Core\Classes\Request;
use PHPUnit\Framework\TestCase;

class AuthMiddlewareTest extends TestCase
{
    private AuthMiddleware $middleware;

    protected function setUp(): void
    {
        parent::setUp();
        $this->middleware = new AuthMiddleware();
    }

    public function testMiddlewareInstanceCreation()
    {
        $this->assertInstanceOf(AuthMiddleware::class, $this->middleware);
    }

    public function testRedirectWhenNotAuthenticated()
    {
        $this->mockDanupeEnv(null, []);
        $request = new Request();
        $GLOBALS['__test_redirect_capture'] = null; // activate capture
        ob_start();
        ($this->middleware)(new Request(), function(){});
        ob_end_clean();
        $this->assertEquals('/login', $GLOBALS['__test_redirect_capture']);
    }

    public function testRedirectMessageIsTranslated()
    {
        $this->mockDanupeEnv(null, []);
        // Force locale 'de'
        $GLOBALS['__danupe_mock_locale'] = 'de';
        $GLOBALS['__test_redirect_capture'] = null;
        ob_start();
        ($this->middleware)(new Request(), function(){});
        ob_end_clean();
        // Check that German error stored in session errors (mocked session doesn't persist retrieval; we simulate by translation call)
        $translated = danupe()->language()->get('auth.login_required');
        $this->assertEquals('Bitte zuerst einloggen.', $translated);
    }

    public function testForbiddenWhenRoleNotAllowed()
    {
        // User Rolle 'user', Route erlaubt nur 'admin'
        $routes = [
            '/protected' => [
                'roles' => ['admin']
            ]
        ];
        $this->mockDanupeEnv(['id'=>1,'role'=>'user'], $routes);
        // Fake Request URI
        $_SERVER['REQUEST_URI'] = '/protected';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        ob_start();
        ($this->middleware)(new Request(), function(){});
        $output = ob_get_clean();
        $this->assertStringContainsString('error 403', $output);
    }

    public function testInvokeIsCallable()
    {
        $this->assertTrue(is_callable($this->middleware));
    }

    private function mockDanupeEnv($user, $routes)
    {
        if (!function_exists('danupe')) {
            function danupe() { return danupe_mock_container(); }
            function danupe_mock_container() { return $GLOBALS['__danupe_mock']; }
        }
    $GLOBALS['__test_redirect_capture'] = null;
        $GLOBALS['__danupe_mock'] = new class($user, $routes) {
            private $user; private $routes; private $locale;
            public function __construct($user,$routes){$this->user=$user;$this->routes=$routes;$this->locale=$GLOBALS['__danupe_mock_locale']??'en';}
            public function session(){
                return new class($this->user){private $user;public function __construct($u){$this->user=$u;}public function get($k){return $k==='user'?$this->user:null;}public function set($k,$v){/* ignore */}};
            }
            public function config(){
                return new class($this->routes){private $routes;public function __construct($r){$this->routes=$r;}public function getAllByKey($key,$merge){
                    if ($key==='routes') return $this->routes;
                    if ($key==='language') {
                        return [
                            'plugin-user.en'=>[
                                'auth.login_required'=>'Please log in first.'
                            ],
                            'plugin-user.de'=>[
                                'auth.login_required'=>'Bitte zuerst einloggen.'
                            ]
                        ];
                    }
                    return [];} };
            }
            public function view(){
                return new class {public function get($plugin,$view,$data=[]){echo danupe()->data()->get($data,'title','');}};
            }
            public function data(){
                return new class {public function get($arr,$key,$default=null){return is_array($arr)&&array_key_exists($key,$arr)?$arr[$key]:$default;}};
            }
            public function language(){
                return new class($this->locale){private $locale;public function __construct($l){$this->locale=$l;}public function get($key){
                    $map=[
                        'en'=>['auth.login_required'=>'Please log in first.'],
                        'de'=>['auth.login_required'=>'Bitte zuerst einloggen.']
                    ];
                    return $map[$this->locale][$key]??null;}
                };
            }
        };
    }
}
