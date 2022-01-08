@extends('multiuser::layouts.auth')

@section('form')
    <form class="login100-form validate-form" method="POST" action="{{ route('multiuser.login') }}?user={{$userType}}">
        @csrf
        <span class="login100-form-title">
            {{Str::ucfirst(config('multiuser.roles')[$userType]['name'])}}
        </span>



        <div class="wrap-input100 validate-input @error('email') alert-validate @enderror"
            data-validate="@error('email') {{ $message }} @else Input valid email @enderror">



            <input id="emaili" type="text" placeholder="Email/Phone" class="input100" name="email" value="{{ old('email') }}" required
                autocomplete="email">

            <span class="focus-input100"></span>
            <span class="symbol-input100">
                <i class="fa fa-user" aria-hidden="true"></i>
            </span>



        </div>

        <div class="wrap-input100 validate-input @error('password') alert-validate @enderror"
            data-validate="@error('password') {{ $message }} @else Password is required @enderror">
            <input class="input100" type="password" name="password" placeholder="Password" required
                autocomplete="current-password">
            <span class="focus-input100"></span>
            <span class="symbol-input100">
                <i class="fa fa-lock" aria-hidden="true"></i>
            </span>

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="container-login100-form-btn">
            <button class="login100-form-btn">
                Login
            </button>
        </div>

        <div class="text-center p-t-12">
            <span class="txt1">
                Forgot
            </span>
            <a class="txt2" href="{{ route('multiuser.password.request') }}?user={{$userType}}">
                Username / Password?
            </a>
        </div>

        <div class="text-center p-t-136">
            <a class="txt2" href="{{route('multiuser.register')}}">
                Create your Account
                <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
            </a>
        </div>
    </form>
@endsection
