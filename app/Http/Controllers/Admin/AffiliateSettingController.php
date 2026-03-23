<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AffiliateSetting;
use Illuminate\Http\Request;

class AffiliateSettingController extends Controller
{
    public function index()
    {
        $title = 'Affiliate Settings';
        $page = 'admin.affiliate.setting';
        $setting = AffiliateSetting::latest()->first();
        $js = ['affiliate'];
        return view('layouts.admin.layout', compact('title', 'page', 'js', 'setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'commission_amount' => 'required|numeric|min:0',
        ], [
            'commission_amount.required' => 'Please enter commission amount',
            'commission_amount.numeric' => 'Commission amount must be a number',
            'commission_amount.min' => 'Commission amount must be 0 or greater',
        ]);

        $setting = AffiliateSetting::latest()->first();

        if ($setting) {
            //  Update existing setting
            $setting->update([
                'commission_amount' => $request->commission_amount,
            ]);
        } else {
            // Create first time
            AffiliateSetting::create([
                'commission_amount' => $request->commission_amount,
            ]);
        }

        return redirect()->back()->with('msg_success', 'Commission amount updated successfully');
    }
}
