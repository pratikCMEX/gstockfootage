<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{

    public function loginPage(Request $request)
    {
        $title = 'Login';
        $page = 'auth.front.login';
        $js = ['login'];
        return view("layouts.front.auth_layout", compact('title', 'page', 'js'));
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('home')
                ->with('success', 'Login successful');
        }

        return back()->with('error', 'Invalid email or password');
    }

    public function register(Request $request)
    {

        $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        $user = User::create([
            'name' => $request->first_name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => strtolower($request->email),
            'password' => Hash::make($request->password),
            'role' => '0',
        ]);

        Auth::login($user);

        return redirect()->route('home')
            ->with('success', 'Account created successfully');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function dashboard()
    {
        return view('dashboard');
    }
}
