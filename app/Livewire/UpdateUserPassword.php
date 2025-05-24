<?php

namespace App\Livewire;

use App\Models\User;
use App\Rules\OldPasswordNoMatch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;

class UpdateUserPassword extends Component
{
    public $passwords = [
        'currentPassword' => '',
        'password' => '',
        'password_confirmation' => '',
    ];

    public function render()
    {
        return view('livewire.update-user-password');
    }

    public function updatePassword()
    {
        $this->resetErrorBag();
        $this->validatePasswords();

        if (Hash::check($this->passwords['password'], auth()->user()->password)) {
            $this->addError('password', 'The new password must be different from the current password.');
            return;
        }

        Auth::logoutOtherDevices($this->passwords['currentPassword']);

        User::where('id', auth()->user()->id)->update([
            'password' => Hash::make($this->passwords['password'])
        ]);

        $this->dispatch('passwordUpdated');
        $this->js("toastr.success('Your password has been updated successfully');");

        $this->passwords = [
            'currentPassword' => '',
            'password' => '',
            'password_confirmation' => '',
        ];
    }

    protected function validatePasswords()
    {
        return Validator::make($this->passwords, [
            'currentPassword' => ['required', 'string', 'currentPassword:web'],
            'password' => ['required', 'string', 'confirmed'],
        ], [
            'currentPassword.required' => 'The current password field is required.',
            'currentPassword.current_password' => 'The provided password does not match your current password.',

        ])->validateWithBag('updateUserProfile');
    }

    private function deleteOtherSessionRecords()
    {
        DB::table( 'sessions')
            ->where('user_id', Auth::user()->getAuthIdentifier())
            ->where('id', '!=', request()->session()->getId())
            ->delete();
    }
}
