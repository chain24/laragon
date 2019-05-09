<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * 开放email和phone登录
     * @author wuzq
     * @return string
     */
    public function username()
    {
        $email = request()->input('email');
        $filed = filter_var($email,FILTER_VALIDATE_EMAIL) ? 'email' : 'phone_number';
        request()->merge([$filed => $email]);
        return$filed;
    }

    public function credentials(Request $request)
    {
        $credentials = $request->only($this->username(),'password');//只取username 和 password
        $credentials = array_add($credentials,'active','1');
        return $credentials;
    }
}
