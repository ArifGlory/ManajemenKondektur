<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

session_start();

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
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function username()
    {
        return 'email';
    }

//    public function showLoginForm()
//    {
//        dd('ngehek');
//    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $_SESSION['ngehe'] = "ada nih sesi nya";
    }

    public function  login(Request $request)
    {
        $input = $request->all();

        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);

        //$fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if(auth()->attempt(array('email' => $input['email'], 'password' => $input['password'])))
        {
            unset($_SESSION["error_login"]);
            return redirect()->route('dashboard');
        }else{
            $_SESSION["error_login"] = "Login gagal, cek email atau password anda";

            return redirect()->back()->with('error_login','Login gagal, cek email atau password anda');

        }
    }
}
