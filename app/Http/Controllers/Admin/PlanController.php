<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\UserPlanDataTable;

use App\Http\Controllers\Controller;
use App\Models\UserPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PlanController extends Controller
{
    public function index(UserPlanDataTable $DataTable)
    {
        $title = 'User Plans List';
        $page = 'admin.user.user_plan_list';
        $js = ['user'];
        return $DataTable->render('layouts.admin.layout', compact('title', 'page', 'js'));
    }

    public function delete(string $id)
    {
        try {
            DB::beginTransaction();
            $id = decrypt($id);

            $video = UserPlan::findOrFail($id);

            $video->delete();

            DB::commit();

            return redirect()
                ->route('admin.transactions')
                ->with('msg_success', 'User Plan deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with('msg_error', 'Error Deleteing User plan: ' . $e->getMessage());
        }
    }
}
