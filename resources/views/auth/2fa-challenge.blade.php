@extends('auth.layouts.app')

@section('content')
    <div class="card-body login-card-body">
        <p class="login-box-msg p-0">
            Please confirm access to your account by entering the authentication code provided by your authenticator application.
        </p>
        <form action="{{route('login.2fa')}}" method="post">
            <div class="card-body login-card-body">
                <div class="form-group mb-3">
                    <label for="code">Code</label>
                    <input type="text" id="code" name="code" class="form-control" required autofocus>
                    @if(session('error'))
                        <p style="color: red">{{session('error')}}</p>
                    @endif
                </div>

            </div>
            <div class="card-footer">

                <a href="{{route('two-factor-recovery')}}">Use a recovery code</a>
                @csrf
                <button class="btn btn-secondary float-right">Verify</button>
            </div>
        </form>
    </div>
@endsection
