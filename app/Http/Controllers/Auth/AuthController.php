<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class AuthController extends Controller
{

    public function loginPage(Request $request)
    {
        $title = 'Login';
        $page = 'auth.front.login';
        $js = ['login'];
        return view("layouts.front.auth_layout", compact('title', 'page', 'js'));
    }
    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required'
    //     ]);

    //     $credentials = $request->only('email', 'password');

    //     if (Auth::attempt($credentials)) {

    //         if (Auth::user()->email_verified_at == null) {
    //             Auth::logout();
    //             return back()->with('msg_error', 'Your email is not verified. Please verify from mail then login.');
    //         }

    //         $request->session()->regenerate();
    //         mergeSessionCart();
    //         return redirect()->route('home')
    //             ->with('msg_success', 'Login successful');
    //     }

    //     return back()->with('msg_error', 'Invalid email or password');
    // }

  
  public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {

        $user = Auth::user();

        if (!$user->email_verified_at) {
            Auth::logout();
            return back()->with('msg_error', 'Your email is not verified. Please verify from mail then login.');
        }

        $request->session()->regenerate();
        mergeSessionCart();

        return redirect()->route('home')
            ->with('msg_success', 'Login successful');
    }

    return back()->with('msg_error', 'Invalid email or password');
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

    event(new Registered($user)); // sends verification email

    return redirect()->route('login')
        ->with('msg_success', 'Account created. Please check your email to verify.');
}

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function checkUserIsExist(Request $request)
    {
        try {
            $category = User::where(['email' => $request->email])->get();
            if (count($category) > 0) {
                if (isset($request->id) && !empty($request->id)) {
                    if ($category[0]->id == decrypt($request->id)) {
                        $return = true;
                        echo json_encode($return);
                        exit;
                    }
                }
                $return = false;
            } else {
                $return = true;
            }
            echo json_encode($return);
            exit;
        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json(false);
        }
    }

    public function checkUserValid(Request $request)
    {
        try {
            $user = User::where('email', $request->email)->first();

            // If user exists -> VALID (return true)
            if ($user) {
                return response()->json(true);
            }

            // If user not exists -> INVALID (return false)
            return response()->json(false);
        } catch (\Exception $e) {
            return response()->json(false);
        }
    }

    public function dashboard()
    {
        return view('dashboard');
    }
}
