@extends('auth.layouts.app')

@section('content')
    <div class="card-body login-card-body">
        <p class="login-box-msg">Please confirm your password before continuing.</p>
        <form action="{{route('password.confirm')}}" method="post">
            <div class="input-group mb-3">
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
                @error('password')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="row">
                <div class="col-12">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-block">Confirm Password</button>
                </div>
            </div>
        </form>
        @if (Route::has('password.request'))
            <a class="btn btn-link" href="{{ route('password.request') }}">
                {{ __('Forgot Your Password?') }}
            </a>
        @endif
    </div>
@endsection
