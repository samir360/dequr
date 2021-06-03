<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    //protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);


        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return response()->json(['status' => 'fail', 'message' => 'Alerta, ha consumido el intento de login']);
        }

        if ($this->attemptLogin($request)) {

            $this->incrementLoginAttempts($request);
            session(['user_admin_id' => Auth::user()->id, 'email' => $request->input('email'), 'password' => bcrypt($request->password)]);

            if (Auth::user()->rol_id==1 || Auth::user()->rol_id==2) { //ANDMINISTRADOR O OPERADOR
                return response()->json(['status' => 'success', 'backend' => true]);
            }else{
                return response()->json(['status' => 'success', 'frontend' => true]);
            }

        }

        if ($request->loginFront) {
            return response()->json(['status' => 'fail', 'message' => 'Alerta, los datos son incorrectos']);
        }

        return response()->json(['status' => 'fail', 'message' => 'Alerta, los datos son incorrectos']);
    }

    public function showFrmLogin()
    {
        return view('auth.login');
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
