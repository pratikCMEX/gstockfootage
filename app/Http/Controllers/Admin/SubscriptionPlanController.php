<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\SubscriptionPlanDataTable;
use App\DataTables\SubscriptionsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Subscription_plans;
use App\Models\Subscriptions;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class SubscriptionPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SubscriptionPlanDataTable $DataTable)
    {
        $title = 'Subscription Plans';
        $page = 'admin.subscriptions.list';
        $js = ['subscription'];
        return $DataTable->render('layouts.admin.layout', compact('title', 'page', 'js'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Add Subscription Plan';
        $page = 'admin.subscriptions.add';
        $js = ['subscription'];

        return view("layouts.admin.layout", compact(
            'title',
            'page',
            'js'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'duration_type' => 'required',
                'duration_value' => 'required',
                'total_clips' => 'required',
                'discount' => 'required',
                'price' => 'required',

            ]);

            Subscription_plans::create([
                'name' => $request->name,
                'duration_type' => $request->duration_type,
                'duration_value' => $request->duration_value,
                'total_clips' => $request->total_clips,
                'discount_percentage' => $request->discount,
                'price' => $request->price,
                'price_per_clip' => $request->price / $request->total_clips,
            ]);
            return redirect()->route('admin.subscriptions')->with('msg_success', 'Subscription Plan Add successfully !');
        } catch (QueryException $e) {

            return redirect()->route('admin.subscription_add')->with('msg_error', 'Subscription Plan not added' . $e->getMessage());
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
        $subscription_plan_id = decrypt($id);

        $title = 'Edit subscription plan';
        $page = 'admin.subscriptions.edit';
        $js = ['subscription'];

        $subscriptionId = $id;
        $getSubscriptionPlanDetail = Subscription_plans::where('id', $subscription_plan_id)->first();

        return view('layouts.admin.layout', compact('title', 'page', 'js', 'getSubscriptionPlanDetail', 'subscriptionId'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'duration_type' => 'required',
                'duration_value' => 'required',
                'total_clips' => 'required',
                'discount' => 'required',
                'price' => 'required',

            ]);

            $subscription_plan_id = decrypt($request->subscription_plan_id);
            $getData = Subscription_plans::where('id', $subscription_plan_id)->first();
     
            $getData->name = $request->name;
            $getData->duration_type = $request->duration_type;
            $getData->duration_value = $request->duration_value;
            $getData->total_clips = $request->total_clips;
            $getData->discount_percentage = $request->discount;
            $getData->price = $request->price;
            $getData->price_per_clip = $request->price / $request->total_clips;
            $getData->save();

            return redirect()->route('admin.subscriptions')->with('msg_success', 'License Updated successfully !');
        } catch (QueryException $e) {

            return redirect()->route('admin.subscription_edit', $subscription_plan_id)->with('msg_error', 'License not updated' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        try {

            $id = decrypt($request->id);
            $license = Subscription_plans::findOrFail($id);


            $license->delete();
            return response()->json([
                'success' => true,
                'message' => 'Subscription Plan deleted successfully.'
            ]);

        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting Subscription Plan.'
            ]);
        }
    }
    public function change_is_active(Request $request)
    {
        try {
            $id = decrypt($request->id);
            $status = $request->status;

            $license = Subscription_plans::find($id);
            $license->is_active = $status;

            $license->save();
            return response()->json(['success' => true]);

        } catch (QueryException $e) {

            return response()->json(['success' => false]);
        }
    }
}
