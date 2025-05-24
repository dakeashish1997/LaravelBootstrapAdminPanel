<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\AppHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\OldPasswordNoMatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function profile(Request $request)
    {
        return view('auth.profile');
    }

    public function profileUpdate(Request $request)
    {
        $update['name'] = $request->name;
        $update['mobile'] = $request->mobile;

        if ($request->password) {
            $validator = Validator::make($request->all(), [
                'password' => ['required', new OldPasswordNoMatch],
            ]);
            if ($validator->fails()) {
                return back()->withError($validator->errors()->first());
            }
            $update['password'] = Hash::make($request->password);
        }

        if ($request->file('photo')) {
            $validator = Validator::make($request->all(), [
                'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
            if ($validator->fails()) {
                return back()->withError($validator->errors()->first());
            }

            $file = $request->file('photo');
            $name = 'photo_' . AppHelper::instance()->randomid() . '.' . $file->getClientOriginalExtension();
            $storagepath = 'profile/' . $name;

            $update['photo'] = AppHelper::uploadFileToStorage($file, $storagepath);
        }
        User::where('id', auth()->user()->id)->update($update);
        if ($request->redirect) {
            return Redirect::to($request->redirect);
        }
        return back()->withSuccess('Profile updated successfully');
    }
}
