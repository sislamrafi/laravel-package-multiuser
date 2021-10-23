<?php

namespace Sislamrafi\Multiuser\app\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\VerifiesEmails;
use \Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\JsonResponse;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails {
        verify as originalVerify;
    }

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = 'admins';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    

    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('auth-admin');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');

        //$this->redirectTo=route(config('multiuser.roles')[$request->user]['redirect']);
    }

    public function show(Request $request)
    {
        if(auth()->check()){
            foreach(config('multiuser.roles') as $key=>$val){
                if(auth()->user()->hasRole($key)){
                    $this->redirectTo = route($val['redirect']);
                    break;
                }
            }
        }else{
            $this->redirectTo = '/';
        }

        return $request->user()->hasVerifiedEmail()
                        ? redirect( $this->redirectTo )
                        : view("multiuser::verify");
    }

    public function verifyXX(Request $request)
    {
        $request->setUserResolver(function () use ($request) {
            return User::findOrFail($request->route('id'));
        });
        return $this->originalVerify($request);
    }

    public function verify(Request $request)
    {
        $user = User::find($request->route('id'));

        if (!auth()->check()) {
            //auth()->loginUsingId($request->route('id'));
        }

        foreach(config('multiuser.roles') as $key=>$val){
            if($user->hasRole($key)){
                $this->redirectTo = route($val['redirect']);
                break;
            }
        }

        //$this->redirectTo = route(config('multiuser.roles')[$request->user]['redirect'].'user='.$request->user);

        if (! hash_equals((string) $request->route('id'), (string) $request->user()->getKey())) {
            throw new AuthorizationException;
        }

        if (! hash_equals((string) $request->route('hash'), sha1($request->user()->getEmailForVerification()))) {
            throw new AuthorizationException;
        }

        if ($request->user()->hasVerifiedEmail()) {
            return $request->wantsJson()
                        ? new JsonResponse([], 204)
                        : redirect($this->redirectPath());
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        if ($response = $this->verified($request)) {
            return $response;
        }

        return $request->wantsJson()
                    ? new JsonResponse([], 204)
                    : redirect($this->redirectPath())->with('verified', true);
    }

    
    protected function showLinkRequestForm()
    {
        return view('multiuser::verify');
    }

    
}
