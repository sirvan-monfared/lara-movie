<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Hash;

class AccountController extends Controller
{
    public function changePassword(){
        return view('admin.account.change-password');
    }

    public function updatePassword(){
        $validator = request()->validate([
            'old-password' => 'required',
            'password' => ['required', 'same:password', 'min:8'],
            'password-confirm' => 'required|same:password',
        ]);

        if(! Hash::check(request('old-password'), auth()->user()->password)) {
            return back()->with('flash-error', 'رمز عبور فعلی نامعتبر است');
        }

        auth()->user()->update([
            'password' => Hash::make(request('password'))
        ]);

        return back()->with('flash', 'رمز عبور با موفقیت تغییر یافت');
    }
}
