<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\AffiliateDataTable;
use App\Http\Controllers\Controller;
use App\Models\Affiliate;
use App\Models\AffiliateUser;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AffiliateController extends Controller
{

    public function index(AffiliateDataTable $DataTable)
    {
        $title = 'Affiliates';
        $page = 'admin.affiliate.list';
        $affiliates = Affiliate::with('affiliateUser')
            ->latest()
            ->paginate(10);
        $js = ['affiliate'];
         $css = 'affiliate';
        // return view('layouts.admin.layout', compact('title', 'page', 'js', 'affiliates'));
        return $DataTable->render('layouts.admin.layout', compact('title', 'page', 'js', 'affiliates','css'));
    }
    public function create()
    {

        $title = 'Affiliates';
        $page = 'admin.affiliate.add';
        $js = ['affiliate'];
        $css = 'affiliate';
        return view('layouts.admin.layout', compact('title', 'page', 'js', 'css'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:affiliate_users,email',
            'password' => 'required|min:6',
            'address' => 'min:10',
            'commission_type' => 'required|in:fixed,percentage',
            'commission_value' => 'required|numeric|min:0',

        ], [
            'first_name.required' => 'Please enter first name',
            'last_name.required' => 'Please enter last name',
            'email.required' => 'Please enter email',
            'email.unique' => 'This email is already registered',
            'password.required' => 'Please enter password',
            'password.min' => 'Password must be at least 6 characters',
            'address.min' => 'Address should be minimum 10 character',
            'commission_type.required' => 'Please select commission type',
            'commission_value.required' => 'Please enter commission value',
            'commission_value.numeric' => 'Please enter valid number',
            'commission_value.min' => 'Value must be 0 or greater',
        ]);

        DB::beginTransaction();

        try {
            // Create user
            $affiliateUser = AffiliateUser::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'country_code' => $request->country_code,
                'address' => $request->address,
            ]);
            // Generate referral code
            $referralCode = Affiliate::generateReferralCode($request->first_name);


            //  Create affiliate
            Affiliate::create([
                'affiliate_user_id' => $affiliateUser->id,
                'referral_code' => $referralCode,
                'commission_type' => $request->commission_type,
                'commission_value' => $request->commission_value,
                'status' => 'active',
            ]);

            DB::commit();

            return redirect()->route('admin.affiliates.list')
                ->with('msg_success', 'Affiliate created successfully. Referral Code: ' . $referralCode);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('msg_error', $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {

        $title = 'Affiliates Edit';
        $page = 'admin.affiliate.edit';
        $js = ['affiliate'];

        $css = 'affiliate';
        $affiliate = Affiliate::with('affiliateUser')->findOrFail($id);

        return view('layouts.admin.layout', compact('title', 'page', 'js', 'css', 'affiliate'));

    }
    public function update(Request $request, $id)
    {
        $affiliate = Affiliate::with('affiliateUser')->findOrFail($id);

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:affiliate_users,email,' . $affiliate->affiliate_user_id,
            'address' => 'nullable|min:10',
            'password' => 'nullable|min:6',
            'commission_type' => 'required|in:fixed,percentage',
            'commission_value' => 'required|numeric|min:0',
        ], [
            'first_name.required' => 'Please enter first name',
            'last_name.required' => 'Please enter last name',
            'email.required' => 'Please enter email',
            'email.unique' => 'This email is already registered',
            'address.min' => 'Address must be at least 10 characters',
            'password.min' => 'Password must be at least 6 characters',
            'commission_type.required' => 'Please select commission type',
            'commission_value.required' => 'Please enter commission value',
            'commission_value.numeric' => 'Please enter valid number',
            'commission_value.min' => 'Value must be 0 or greater',
        ]);

        DB::beginTransaction();

        try {
            //  Update user
            $userData = [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone_number ?? '',
                'country_code' => $request->country_code,
                'address' => $request->address ?? '',
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $affiliate->affiliateUser->update($userData);
            $affiliate->update([
                'commission_type' => $request->commission_type,
                'commission_value' => $request->commission_value,
            ]);

            DB::commit();

            return redirect()->route('admin.affiliates.list')
                ->with('msg_success', 'Affiliate updated successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('msg_error', $e->getMessage())
                ->withInput();
        }
    }
    public function toggleStatus(Request $request)
    {

        try {
            $id = decrypt($request->id);
            $status = $request->status;

            $affiliate = Affiliate::find($id);
            $affiliate->status = $status;

            $affiliate->save();
            return response()->json(['success' => true]);

        } catch (QueryException $e) {

            return response()->json(['success' => false]);
        }

    }
    public function checkAffiliateIsExist(Request $request)
    {
       
        try {
            $user = AffiliateUser::where(['email' => $request->email])->get();
            if (count($user) > 0) {
                if (isset($request->id) && !empty($request->id)) {
                    if ($user[0]->id ==$request->id) {
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
    public function destroy(Request $request)
    {

        try {
            DB::beginTransaction();
            $id = decrypt($request->id);
            $affiliate = Affiliate::findOrFail($id);
            $affiliate->delete();
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Affiliate User deleted successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Affiliate User not deleted'
            ]);
        }
    }
}
