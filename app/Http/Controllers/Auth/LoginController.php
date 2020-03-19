<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Jasny\SSO\Broker;
use Jasny\SSO\Exception as SsoException;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->broker = new Broker(
            'https://sso.bcsoetta.org/',
            '9',
            'q9Qk3e8PXS'
        );
        $this->middleware('guest')->except('logout');
        
    }
    
    public function login(Request $request){

        // $this->broker->attach();
        // $this->validateLogin($request);

        try {
            $this->broker->login("m.rinaldi", "123456");

            $details = $this->broker->getUserInfo();

            return $details;

        } catch (\Exception | SsoException $e) {

            return $e->getMessage();
        }
    }

    public function logout()
    {
        try {
            //code...
            $this->broker->logout();
        } catch (\Exception | SsoException $e) {
            $e->getMessage();

            return redirect('login');
        }


    }

}
