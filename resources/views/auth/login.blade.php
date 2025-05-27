@extends('auth.layouts.app')

@section('content')
    <div class="card-body login-card-body">
        <p class="login-box-msg">Sign in to start your session</p>
        <form action="{{route('login')}}" method="post">
            @error('email')
            <div class="alert alert-warning">
                {{ $message }}
            </div>
            @enderror
            @error('password')
            <div class="alert alert-warning">
                {{ $message }}
            </div>
            @enderror
            <div class="input-group mb-3">
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
            </div>

            <div class="input-group mb-3">
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-8">
                    <div class="icheck-primary">
                        <input type="checkbox" name="remember" id="remember">
                        <label for="remember">
                            Remember Me
                        </label>
                    </div>
                </div>

                <div class="col-4">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                </div>

            </div>
        </form>
        @if (config('features.update-reset-password'))
            <p class="mb-1">
                <a href="{{ route('password.request') }}">
                    I forgot my password
                </a>
            </p>
        @endif
        @if (config('features.update-user-registration'))
            <p class="mb-0">
                <a href="{{route('register')}}" class="text-center">Register here</a>
            </p>
        @endif
    </div>
@endsection
