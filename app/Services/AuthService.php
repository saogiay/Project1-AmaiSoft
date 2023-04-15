<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    // Xác thực người dùng
    public function authenticate($request): bool
    {
        $remember = $request->has('remember') ? true : false;

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Chưa nhập email',
            'email.email' => 'Sai định dạng email',
            'password.required' => 'Chưa nhập mật khẩu'
        ]);

        if (Auth::attempt($credentials, $remember)) {
            return true;
        }
        return false;
    }

    // Cập nhật mật khẩu
    public function updatePassword($request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required',
        ]);

        if (!Hash::check($request->old_password, auth()->user()->password)) {
            return false;
        }

        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);
        return true;
    }
}
