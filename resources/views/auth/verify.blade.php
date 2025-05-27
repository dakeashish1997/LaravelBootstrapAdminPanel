@extends('auth.layouts.app')

@section('content')
    <div class="card-body login-card-body">
        @if (session('resent'))
            <div class="alert alert-success" role="alert">
                A fresh verification link has been sent to your email address.
            </div>
        @endif
        <div class="login-box-msg">
            Before proceeding, please check your email for a verification link. If you did not receive the email
            <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>
            </form>
        </div>

    </div>
@endsection
