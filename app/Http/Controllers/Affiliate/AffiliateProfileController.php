<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AffiliateProfileController extends Controller
{
    public function index()
    {
        $title = 'My Profile';
        $page = 'affiliate.profile';
        $js = ['affiliate_profile'];
        $affiliateUser = Auth::guard('affiliate')->user();
        $affiliate = $affiliateUser->affiliate;

        ;
        return view('layouts.admin.layout', compact(
            'title',
            'page',
            'js',
            'affiliateUser',
            'affiliate'
        ));
    }
    public function update_profile(Request $request)
    {
        $affiliateUser = Auth::guard('affiliate')->user();

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:affiliate_users,email,' . $affiliateUser->id,
            'phone' => 'nullable',
            'address' => 'nullable|min:10',
            'password' => 'nullable|min:6|confirmed',
        ], [
            'first_name.required' => 'Please enter first name',
            'last_name.required' => 'Please enter last name',
            'email.required' => 'Please enter email',
            'email.unique' => 'This email is already registered',
            'address.min' => 'Address must be at least 10 characters',
            'password.min' => 'Password must be at least 6 characters',
            'password.confirmed' => 'Passwords do not match',
        ]);

        $data = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'country_code' => $request->country_code,
            'address' => $request->address,
        ];

        //  Only update password if provided
        // if ($request->filled('password')) {
        //     $data['password'] = Hash::make($request->password);
        // }

        $affiliateUser->update($data);

        return redirect()->back()
            ->with('msg_success', 'Profile updated successfully');
    }
}
