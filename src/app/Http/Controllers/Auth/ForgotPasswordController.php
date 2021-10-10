<?php

namespace Sislamrafi\Multiuser\app\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function showLinkRequestForm(Request $request)
    {
        $userType = NULL;
        if(isset($request->user) && isset(config('multiuser.roles')[$request->user])){
            $userType = $request->user;
        }
        return view('multiuser::email',['userType'=> $userType]);
    }

    protected function broker()
    {
        return Password::broker('users');
    }
}
