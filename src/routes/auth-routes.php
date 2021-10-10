<?php

/*
    use middleware 'admin-verified' to check email verification
    use middleware 'auth-admin' to guard admin
*/

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Auth::routes(['verify' => true]);

Route::get('/', function(){
    return "Hi multiuserX";
})->name('root');

Route::get('/i', function(){
    return "Hi multiuserXi";
})->name('rooti');

//Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');


//Route::get('/login', [Sislamrafi\Admin\app\Http\Controllers\Auth\LoginController::class,'showAdminLoginForm'] )->name('login');
//Route::post('/login', [Sislamrafi\Admin\app\Http\Controllers\Auth\LoginController::class,'adminLogin'] )->name('login');

