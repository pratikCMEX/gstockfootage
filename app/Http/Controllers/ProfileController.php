<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */


    public function edit(Request $request): View
    {
        // return view('profile.view', [
        //     'user' => $request->user(),
        // ]);
        $user_id = auth()->user()->id;

        $user = User::findOrFail($user_id);
        $title = 'Manage Profile';
        $page = 'profile.view';
        $js = ['profile'];
        $css = 'profile.css';

        return view('layouts.front.layout', compact('title', 'page', 'js', 'css', 'user'));
    }
    public function index()
    {
        $title = 'Profile';
        $page = 'front.profile';
        $js = ['profile'];
        $userId = Auth::id();

        $user_profile = Auth::user();
        // $wishLists = Product::with(['favorites', 'category'])
        //     ->whereHas('favorites', function ($query) use ($userId) {
        //         $query->where('user_id', $userId);
        //     })
        //     ->get();


        return view("layouts.front.layout", compact('title', 'page', 'js', 'user_profile'));
    }

    /**
     * Update the user's profile information.
     */
    public function update_profile(ProfileUpdateRequest $request): RedirectResponse
    {


        try {
            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'phone' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'email' => 'required|string|max:255',
            ]);

            $user_id = decrypt($request->user_id);
            $getData = User::where('id', $user_id)->first();


            $getData->first_name = $request->first_name;
            $getData->last_name = $request->last_name;
            $getData->email = $request->email;
            $getData->phone = $request->phone;
            $getData->address = $request->address;
            $getData->save();

            return redirect()->route('user.profile')->with('msg_success', 'Profile Updated successfully !');
        } catch (QueryException $e) {

            return redirect()->route('user.profile', $user_id)->with('msg_error', 'Profile not updated' . $e->getMessage());
        }
        // $request->user()->fill($request->validated());

        // if ($request->user()->isDirty('email')) {
        //     $request->user()->email_verified_at = null;
        // }

        // $request->user()->save();

        // return Redirect::route('view_profile')->with('status', 'profile-updated');
    }


    public function update_password(Request $request)
    {
        try {
            $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|min:6',
                'confirm_password' => 'required|same:new_password',
            ]);
            $id = $request->id;
            $user = User::findOrFail($id);

            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->route('admin.profile')->with('msg_error', 'Current Password is Incorrect');
            }

            $user->password = Hash::make($request->new_password);
            $user->password_updated_at = now();
            $user->save();
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->with('msg_success', 'Password Updated Successfully. Please login again.');
        } catch (QueryException $e) {

            return redirect()->route('view_profile', $id)->with('msg_error', 'Profile not updated' . $e->getMessage());
        }
    }
    public function check_password(Request $request)
    {
        try {

            $id = $request->id;
            $user = User::findOrFail($id);

            if (!Hash::check($request->current_password, $user->password)) {
                $return = false;
            } else {
                $return = true;
            }
            echo json_encode($return);
            exit;
        } catch (QueryException $e) {


            return response()->json($e);
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
