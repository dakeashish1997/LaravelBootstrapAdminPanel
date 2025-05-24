<?php

namespace App\Livewire;

use App\Helpers\AppHelper;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class UpdateUserProfile extends Component
{
    use WithFileUploads;

    public $user = [];
    public $photo;

    public function render()
    {
        return view('livewire.update-user-profile');
    }

    public function mount()
    {
        $this->user = auth()->user()->toArray();
    }

    public function deleteProfilePhoto()
    {
        $this->user['photo'] = null;
        User::find(auth()->user()->id)->update($this->user);
    }

    protected function validateProfilePhoto()
    {
        $data['photo'] = $this->photo;
        return Validator::make($data, [
            'photo' => ['required', 'max:256']
        ])->validateWithBag('updateProfile');
    }

    public function updatedPhoto()
    {
        $this->resetErrorBag();
        $this->validateProfilePhoto();

        $name = 'photo_' . date('ymdHis') . '.' . $this->photo->getClientOriginalExtension();
        $storagePath = 'profile/' . $name;

        $filePath = AppHelper::uploadFileToStorage($this->photo, $storagePath);

        $this->user['photo'] = $filePath;
        User::find(auth()->user()->id)->update($this->user);

        $this->js("toastr.success('Your photo has been uploaded successfully');");
    }

    protected function validateProfileData()
    {
        return Validator::make($this->user, [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($this->user['id'])],
            'mobile' => ['required', 'string'],
        ])->validateWithBag('updateProfile');
    }

    public function saveProfile()
    {
        $this->resetErrorBag();
        $validated = $this->validateProfileData();

        User::find(auth()->user()->id)->update($validated);

        $this->js("toastr.success('Your profile has been updated successfully');");
    }

}
