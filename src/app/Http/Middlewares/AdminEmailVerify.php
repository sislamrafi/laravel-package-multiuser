<?php

namespace Sislamrafi\Multiuser\app\Http\Middlewares;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class AdminEmailVerify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $redirectToRoute = null)
    {
        //dd("Hi");
        if (!$request->user() ||
            ($request->user() instanceof MustVerifyEmail &&
            ! $request->user()->hasVerifiedEmail())) {
                //dd(URL::route($redirectToRoute ?: 'admin.verification.notice'));
            return $request->expectsJson()
                    ? abort(403, 'Your email address is not verified.')
                    : redirect(URL::route($redirectToRoute ?: 'multiuser.verification.notice'));
        }

        return $next($request);
    }
}
