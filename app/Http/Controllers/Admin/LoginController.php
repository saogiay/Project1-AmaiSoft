<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    // Giao diện đăng nhấp
    public function login()
    {
        return view('clients.admin.login')->with('title', 'Đăng nhập');
    }
    /**
     * Xác thực đăng nhập.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        if ($this->authService->authenticate($request)) {
            return redirect()->route('admin.index');
        } else return back()->withErrors([
            'email' => 'Sai mật khẩu hoặc tài khoản không tồn tại',
        ]);
    }

    // Đăng xuất
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    // Giao diện đổi mật khẩu
    public function changePassword()
    {
        return view('clients.admin.change-password', [
            'title' => 'Đổi mật khẩu'
        ]);
    }

    /**
     * Cập nhật mật khẩu
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request)
    {
        $check = $this->authService->updatePassword($request);
        if ($check) {
            return redirect()->back()->with('success', 'Đổi mật khẩu thành công');
        }
        return redirect()->back()->with("error", "Mật khẩu cũ không chính xác");
    }
}
