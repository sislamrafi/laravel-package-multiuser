@extends('multiuser::layouts.auth')

@section('form')
    <form class="login100-form validate-form" method="POST" action="{{ route('admin.verification.resend') }}">
        @csrf
        <span class="login100-form-title">
            Verify your account.
        </span>


        <div class="text-center p-t-12 m-t-12 alert alert-success">
            <span class="txt1">
                A fresh verification link has been sent to your email address.
            </span>
        </div>



        <div class="text-center p-t-12 m-t-12">
            <span class="txt1">
                Before proceeding, please check your email for a verification link.<br><br><br>
                If you did not receive the email
            </span>

            <button type="submit"
                class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.

        </div>


        <div class="text-center p-t-60">
            <a class="txt2" href="{{ route('admin.login') }}">
                Login to your Account
                <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
            </a>
        </div>
    </form>
@endsection
