<?php

namespace App\Http\Middleware;

use Closure;
use Jasny\SSO\Broker;

class AuthenticateSSO
{

    public function __construct(){
        $this->broker = new Broker(
            'https://sso.bcsoetta.org/',
            '9',
            'q9Qk3e8PXS'
        );
        $this->broker->attach();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($this->authenticateUser() == null){
            return redirect('login');
        };
 
        return $next($request);
    }

    public function authenticateUser(){
        try {
            $userInfo = $this->broker->getUserInfo();
            return $userInfo;
        } catch (\Exception $e) {
            // echo "getUserInfo error: {$e->getMessage()}";
            return null;
        }
   }
}
