@extends('auth.layouts.app')

@section('content')
    <div class="card-body register-card-body">
        <p class="login-box-msg">Register a new membership</p>
        <form action="{{route('register')}}" method="post">
            @error('name')
            <div class="alert alert-warning">
                {{ $message }}
            </div>
            @enderror
            @error('email')
            <div class="alert alert-warning">
                {{ $message }}
            </div>
            @enderror
            @error('mobile')
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
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Full name" required>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-user"></span>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" required>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <input type="tel" name="mobile" class="form-control @error('mobile') is-invalid @enderror" placeholder="Mobile" required>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-phone"></span>
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
            <div class="input-group mb-3">
                <input type="password" name="password_confirmation" class="form-control" placeholder="Retype password" required>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-8">
                    <div class="icheck-primary">
                        <input type="checkbox" id="agreeTerms" name="terms" value="agree" required>
                        <label for="agreeTerms">
                            I agree to the <a href="{{route('terms')}}">terms</a>
                        </label>
                    </div>
                </div>

                <div class="col-4">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-block">Register</button>
                </div>

            </div>
        </form>
        <a href="{{route('login')}}" class="text-center">I already have a membership</a>
    </div>
@endsection
