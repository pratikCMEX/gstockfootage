<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class AuthAdmin extends Controller
{
    public function showLogin()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        $title = 'Login';
        // $page = 'auth.admin.login';
        $page = 'admin.batchs_img.test';
        $js = ['login'];
        return view("layouts.admin.auth_layout", compact('title', 'page', 'js'));
    }

    public function checkLogin(Request $req)
    {
        $req->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = [
            'email' => $req->email,
            'password' => $req->password,
            'role' => "1"
        ];

        if (Auth::guard('admin')->attempt($credentials, $req->remember)) {
            if ($req->has('remember')) {
                Cookie::queue('admin_email', $req->email, 120);
                Cookie::queue('admin_password', $req->password, 120);
            } else {
                Cookie::queue(Cookie::forget('admin_email'));
                Cookie::queue(Cookie::forget('admin_password'));
            }
            $req->session()->regenerate();
            return redirect()->route('admin.dashboard')->with('msg_success', 'Login successful.');
        }

        return back()->withErrors(['email' => 'Invalid email or password'])
            ->onlyInput('email');
    }

    public function logout(Request $req)
    {
        Auth::guard('admin')->logout();
        $req->session()->invalidate();
        $req->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
