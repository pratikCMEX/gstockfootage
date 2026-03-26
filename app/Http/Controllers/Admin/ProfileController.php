<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = auth('admin')->user()->id;

        $user = User::findOrFail($user_id);
        $title = 'Manage Profile';
        $page = 'admin.profile.view';
        $js = ['profile'];
        $css = 'profile';

        return view('layouts.admin.layout', compact('title', 'page', 'js', 'css', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function update_profile(Request $request)
    {
        try {
            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                
                'email' => 'required|string|max:255',
            ]);

            $user_id = decrypt($request->user_id);
            $getData = User::where('id', $user_id)->first();


            $getData->first_name = $request->first_name;
            $getData->last_name = $request->last_name;
            $getData->email = $request->email;
            $getData->phone=$request->phone;
            $getData->country_code=$request->country_code;
            $getData->address=$request->address;
            $getData->save();

            return redirect()->route('admin.profile')->with('msg_success', 'Profile Updated successfully !');
        } catch (QueryException $e) {

            return redirect()->route('admin.profile', $user_id)->with('msg_error', 'Profile not updated' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
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
            $user->save();
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('admin.login')->with('msg_success', 'Password Updated Successfully. Please login again.');
        } catch (QueryException $e) {

            return redirect()->route('admin.profile', $id)->with('msg_error', 'Profile not updated' . $e->getMessage());
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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
