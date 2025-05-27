@extends('auth.layouts.app')

@section('content')
    <div class="card-body login-card-body">
        <p class="login-box-msg p-0">
            Please confirm access to your account by entering one of your emergency recovery codes.
        </p>
        <form action="{{route('login.2fa.recovery')}}" method="post">
            <div class="card-body login-card-body">
                <div class="form-group mb-3">
                    <label for="recoveryCode">Recovery Code</label>
                    <input type="text" id="recoveryCode" name="recoveryCode" class="form-control" required autofocus>
                    @if(session('error'))
                        <p style="color: red">{{session('error')}}</p>
                    @endif
                </div>

            </div>
            <div class="card-footer">
                <a href="{{route('two-factor-challenge')}}">Use an authentication code</a>
                @csrf
                <button class="btn btn-secondary float-right">Verify</button>
            </div>
        </form>
    </div>
@endsection
