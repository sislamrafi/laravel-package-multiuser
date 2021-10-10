@extends('multiuser::layouts.auth')

@section('form')
    <form class="login100-form validate-form" method="POST" action="{{ route('multiuser.password.email') }}">
        @csrf
        <span class="login100-form-title">
            Forget password
        </span>

        <div class="wrap-input100 validate-input @error('email') alert-validate @enderror"
            data-validate="@error('email') {{ $message }} @else Input valid email @enderror">

            <input id="email" placeholder="Email" type="email" class="input100" name="email" value="{{ old('email') }}" required
                autocomplete="email">

            <span class="focus-input100"></span>
            <span class="symbol-input100">
                <i class="fa fa-envelope" aria-hidden="true"></i>
            </span>
        </div>

        <div class="container-login100-form-btn">
            <button class="login100-form-btn">
                Send Reset Link
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
                Login Admin
                <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
            </a>
        </div>
    </form>
@endsection
