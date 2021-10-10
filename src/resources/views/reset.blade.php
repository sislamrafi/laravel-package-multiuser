@extends('multiuser::layouts.auth')

@section('form')
    <form class="login100-form validate-form" method="POST" action="{{ route('multiuser.password.update') }}">
        @csrf
        <span class="login100-form-title">
            Reset Password
        </span>

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="wrap-input100 validate-input @error('email') alert-validate @enderror"
            data-validate="@error('email') {{ $message }} @else Input valid email @enderror">

            <input id="email" type="email" class="input100" placeholder="Email" name="email" value="{{ $email ?? old('email') }}" required
                autocomplete="email" autofocus>

            <span class="focus-input100"></span>
            <span class="symbol-input100">
                <i class="fa fa-envelope" aria-hidden="true"></i>
            </span>



        </div>

        <div class="wrap-input100 validate-input @error('password') alert-validate @enderror"
            data-validate="@error('password') {{ $message }} @else Password is required @enderror">
            <input class="input100" type="password" name="password" placeholder="Password" required
                autocomplete="new-password">
            <span class="focus-input100"></span>
            <span class="symbol-input100">
                <i class="fa fa-lock" aria-hidden="true"></i>
            </span>

        </div>

        <div class="wrap-input100 validate-input @error('password') alert-validate @enderror"
            data-validate="@error('password') {{ $message }} @else Password is required @enderror">
            <input class="input100" type="password" name="password_confirmation" placeholder="Password Confirm" required
                autocomplete="new-password">
            <span class="focus-input100"></span>
            <span class="symbol-input100">
                <i class="fa fa-lock" aria-hidden="true"></i>
            </span>

        </div>

        <div class="container-login100-form-btn">
            <button class="login100-form-btn">
                Change Password
            </button>
        </div>

        @if (session('status'))

            <div class="text-center p-t-12 m-t-12 alert alert-success">
                <span class="txt1">
                    Successful
                </span>
                <a class="txt2" target="blank" href="https://gmail.com">
                    We have mailed you a password reset link.
                </a>
            </div>
        @endif

        <div class="text-center p-t-136">
            <a class="txt2" href="{{ route('multiuser.login') }}?user={{$userType}}">
                Login to your Account
                <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
            </a>
        </div>
    </form>
@endsection
