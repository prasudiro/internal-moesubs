<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Session;
use Auth;

//Call table
use App\User;
use App\UserSession;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {

        $login_with_username = array(
            'name'     => $request['name'],
            'password' => $request['password'],
        );

        $login_with_email = array(
            'email'     => $request['name'],
            'password' => $request['password'],
        );

        if (Auth::attempt($login_with_username)) 
        {
            $last_login = User::where('id', '=', Auth::user()['id'])->update(array('last_login' => date('Y-m-d H:i:s')));

            return redirect()->intended("/")->with('success_msg', '<b>Selamat datang, '.Auth::user()['name'].'!</b><br>Jangan lupa ajukan saran dan masukan melalui menu Pesan.');
        }
        elseif (Auth::attempt($login_with_email)) 
        {
            $last_login = User::where('id', '=', Auth::user()['id'])->update(array('last_login' => date('Y-m-d H:i:s')));

            return redirect()->intended("/")->with('success_msg', '<b>Selamat datang, '.Auth::user()['name'].'!</b><br>Jangan lupa ajukan saran dan masukan melalui menu Pesan.');
        }
        
        return redirect('login')->with('error_msg', 'Tidak punya SIM dan STNK berlaku? Anda saya tilang!');
    }

    public function logout()
    {
        if (Auth::user()) 
        {
            Auth::logout();
            Session::flush();

            return redirect('login')->with('success_msg', 'Terima kasih dan silakan pergi!');
        }
        else
        {
            return redirect('login')->with('error_msg', 'Menunjukkan SIM dan STNK saja belum, tapi sudah mau pergi?!');
        }
        
    }
}
