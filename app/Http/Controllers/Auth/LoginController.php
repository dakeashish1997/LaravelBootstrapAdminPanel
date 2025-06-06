<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->validate2fa($request)) {
            return $this->show2faForm($request);
        }

        if ($this->attemptLogin($request)) {
            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }

            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'exists:users', function ($attribute, $value, $fail) use ($request) {
                if (!User::where('email', $request->email)->first()) {
                    return $fail('User is not active currently. Please contact support team for further details.');
                }
            }],
            'password' => ['required', 'string'],
        ], [
            'email.exists' => 'User with given email does not exists.'
        ]);

        $request->validate([
            'password' => [function ($attribute, $value, $fail) use ($request) {
                $user = User::where('email', $request->email)->first();
                if (!Hash::check($value, $user->password)) {
                    return $fail('You have entered incorrect password.');
                }
            }],
        ]);
    }

    protected function validate2fa(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        return !is_null($user->two_factor_confirmed_at);
    }

    public function show2faForm(Request $request)
    {
        Session::put('request', $request->all());
        return redirect()->route('two-factor-challenge');
    }

    public function twoFactorChallenge()
    {
        return view('auth.2fa-challenge');
    }

    public function attempt2fa(Request $request)
    {
        $oldRequest = Session::get('request');
        $user = User::where('email', $oldRequest['email'])->first();

        $google2fa = app('pragmarx.google2fa');

        if (empty($user->two_factor_secret) ||
            empty($request->code) ||
            !$google2fa->verifyKey(decrypt($user->two_factor_secret), $request->code)) {
            return back()->withError('The provided two factor authentication code was invalid.');
        }

        $request['email'] = $oldRequest['email'];
        $request['password'] = $oldRequest['password'];

        if ($this->attemptLogin($request)) {
            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }

            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    public function twoFactorRecovery()
    {
        return view('auth.2fa-recovery');
    }

    public function attempt2faRecovery(Request $request)
    {
        $oldRequest = Session::get('request');
        $user = User::where('email', $oldRequest['email'])->first();

        $google2fa = app('pragmarx.google2fa');

        if (empty($user->two_factor_secret) ||
            empty($request->recoveryCode) ||
            !$this->validRecoveryCode($user, $request->recoveryCode)) {
            return back()->withError('The provided two factor recovery code was invalid.');
        }

        $user->forceFill([
            'two_factor_recovery_codes' => encrypt(str_replace(
                $request->recoveryCode,
                Str::random(10) . '-' . Str::random(10),
                decrypt($user->two_factor_recovery_codes)
            )),
        ])->save();

        $request['email'] = $oldRequest['email'];
        $request['password'] = $oldRequest['password'];

        if ($this->attemptLogin($request)) {
            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }

            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    private function validRecoveryCode($user, $recoveryCode)
    {
        return in_array($recoveryCode, json_decode(decrypt($user->two_factor_recovery_codes)));
    }

}
