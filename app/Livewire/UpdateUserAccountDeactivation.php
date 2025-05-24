<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class UpdateUserAccountDeactivation extends Component
{
    public $password = '';
    public $alert = '';

    public function render()
    {
        return view('livewire.update-user-account-deactivation');
    }

    public function confirmAccountDeactivation()
    {
        $this->password = '';
        $this->alert = '';
        $this->js("$('#modal-account-deactivation').modal('show');");
    }

    public function deactivateAccount(Request $request)
    {
        if (!Hash::check($this->password, Auth::user()->password)) {
            $this->alert = 'This password does not match our records.';
            return;
        }

        User::find(auth()->user()->id)->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('/');
    }
}
