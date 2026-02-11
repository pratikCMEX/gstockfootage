<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\TransactionsDataTable;
use App\Models\WalletTransactions;
use Illuminate\Support\Facades\DB;

class WalletTransactionsController extends Controller
{
    public function index(TransactionsDataTable $DataTable)
    {
        $title = 'Transactions';
        $page = 'admin.transactions.list';
        $js = ['transactions'];
        return $DataTable->render('layouts.admin.layout', compact('title', 'page', 'js'));
    }

    public function delete(string $id)
    {
        try {
            DB::beginTransaction();
            $id = decrypt($id);

            $video = WalletTransactions::findOrFail($id);

            $video->delete();

            DB::commit();

            return redirect()
                ->route('admin.transactions')
                ->with('msg_success', 'Transaction deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with('msg_error', 'Error Deleteing Transactions: ' . $e->getMessage());
        }
    }
}
