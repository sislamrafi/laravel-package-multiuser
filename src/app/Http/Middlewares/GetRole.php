<?php

namespace Sislamrafi\Admin\app\Http\Middlewares;

use Closure;
use Illuminate\Support\Facades\Auth;

class GetRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard('users')->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect(route('multiauth.login'));
            }
        }else{
             Auth::user()->role();
        }


        //$request->merge(['user' => Auth::guard('admin')->user() ]);
        $user = Auth::guard('admin')->user();

        //add this
        $request->setUserResolver(function () use ($user) {
            return $user;
        });
        
        $response = $next($request);

        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With, Application');
        $response->headers->set('Cache-Control', 'nocache, no-store, max-age=0, must-revalidate');
        $response->headers->set('Pragma', 'no-cache'); //HTTP 1.0
        $response->headers->set('Expires', 'Sat, 01 Jan 1990 00:00:00 GMT'); // // Date in the past

        return $response;
    }
}
