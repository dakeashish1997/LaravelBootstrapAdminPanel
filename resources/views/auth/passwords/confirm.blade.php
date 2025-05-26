<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>{{config('app.name')}}</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="{{'https://site-assets.fontawesome.com/releases/v6.1.1/css/all.css'}}">

    <link rel="stylesheet" href="{{'https://cdn.queensherainfotech.com/panel/plugins/icheck-bootstrap/icheck-bootstrap.min.css'}}">

    <link rel="stylesheet" href="{{'https://cdn.queensherainfotech.com/panel/dist/css/adminlte.min.css?v=3.2.0'}}">

</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="{{route('/')}}">{{config('app.name')}}</a>
    </div>

    <div class="card">
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

    </div>
</div>


<script src="{{'https://cdn.queensherainfotech.com/panel/plugins/jquery/jquery.min.js'}}"></script>

<script src="{{'https://cdn.queensherainfotech.com/panel/plugins/bootstrap/js/bootstrap.bundle.min.js'}}"></script>

<script src="{{'https://cdn.queensherainfotech.com/panel/dist/js/adminlte.min.js'}}"></script>
</body>
</html>

