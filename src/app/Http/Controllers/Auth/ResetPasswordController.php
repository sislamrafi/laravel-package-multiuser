<?php

namespace Sislamrafi\Multiuser\app\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = 'home';

    
    public function showLinkRequestForm(Request $request)
    {   
        $userType = NULL;
        if(isset($request->user) && isset(config('multiuser.roles')[$request->user])){
            $userType = $request->user;
        }
        return view('multiuser::reset',['userType'=> $userType]);
    }
    public function showResetForm(Request $request, $token = null)
    {
        $userType = NULL;
        if(isset($request->user) && isset(config('multiuser.roles')[$request->user])){
            $userType = $request->user;
        }
        return view('multiuser::reset',['userType'=> $userType])->with(
            ['token' => $token, 'email' => $request->email]
        );
    }
}
