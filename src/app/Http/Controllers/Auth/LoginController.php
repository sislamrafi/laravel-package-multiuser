<?php

namespace Sislamrafi\Multiuser\app\Http\Controllers\Auth;

use Sislamrafi\Multiuser\app\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
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
    protected $redirectTo = 'home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user'=>'required',
        ]);

        if(!isset(config('multiuser.roles')[$request->user])){
            abort(403, "No such user type defined");
        }

        if ($validator->fails()) {
            abort(403, $validator->errors());
        }

        return view('multiuser::login',['userType'=>$request->user]);
    }

    public function login(Request $request)
    {
        $valodator =  $this->validate($request, [
            'email'   => 'required|email|exists:users,email',
            'password' => 'required|min:6',
            'user'=>'required',
        ]);

        if ($e = $this->guard('users')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
            
            //return redirect()->intended(route(config('multiuser.roles')[$request->user]));
            return redirect()->route(config('multiuser.roles')[$request->user]['redirect']);
        }
        return back()
        ->withInput($request->only('email', 'remember'))
        ->withErrors(['email'=>"Email or password didn't match"
                    ]);
    }
}