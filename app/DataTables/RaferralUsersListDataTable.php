<?php

namespace App\DataTables;

use App\Models\User;
use App\Models\AffiliateReferral;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\Auth;

class RaferralUsersListDataTable extends DataTable
{
    protected $affiliateId;
    protected $referralCode;

    //  Pass affiliate data to DataTable
    public function __construct()
    {
        $affiliateUser      = Auth::guard('affiliate')->user();
        $this->affiliateId  = $affiliateUser->affiliate->id;
        $this->referralCode = $affiliateUser->affiliate->referral_code;
    }

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $affiliateId = $this->affiliateId;

        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('full_name', function ($row) {
                return $row->first_name . ' ' . $row->last_name;
            })
            ->addColumn('total_orders', function ($row) use ($affiliateId) {
                return AffiliateReferral::where('affiliate_id', $affiliateId)
                    ->where('user_id', $row->id)
                    ->count();
            })
            ->addColumn('total_commission', function ($row) use ($affiliateId) {
                $amount = AffiliateReferral::where('affiliate_id', $affiliateId)
                    ->where('user_id', $row->id)
                    ->sum('commission_amount');
                return number_format($amount, 2);
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('d M Y');
            })

            //  Sorting
            ->orderColumn('full_name',  'first_name $1')
            ->orderColumn('email',      'email $1')
            ->orderColumn('created_at', 'created_at $1')

            //  Searching
            ->filterColumn('full_name', function ($query, $keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('first_name', 'like', "%{$keyword}%")
                      ->orWhere('last_name', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('email', function ($query, $keyword) {
                $query->where('email', 'like', "%{$keyword}%");
            })

            ->rawColumns([])
            ->setRowId('id');
    }

    public function query(User $model): QueryBuilder
    {
        //  Only fetch users referred by this affiliate
        return $model->newQuery()
            ->where('referred_by', $this->referralCode)
            ->select('id', 'first_name', 'last_name', 'email', 'created_at');
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('raferraluserslist-table')
            ->columns($this->getColumns())
            ->ajax([
                'url'  => route('affiliate.referrals'),
                'type' => 'GET',
            ])
            ->orderBy(5, 'desc') //  created_at = index 5
            ->selectStyleSingle()
            ->parameters([
                'dom'        => 'Blfrtip',
                'pageLength' => 10,
                'lengthMenu' => [[10, 25, 50, 100], [10, 25, 50, 100]],
            ])
            ->buttons([
                // Button::make('pdf')->exportOptions(['columns' => ':visible']),
            ]);
    }

    public function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex')
                ->title('Sr. No.')
                ->exportable(false)
                ->printable(false)
                ->orderable(false)
                ->width(50)
                ->addClass('text-center'),

            Column::make('full_name')
                ->title('User Name'),

            Column::make('email')
                ->title('Email'),

            Column::make('total_orders')
                ->title('Total Orders')
                ->orderable(false)
                ->searchable(false),

            Column::make('total_commission')
                ->title('Total Commission ($)')
                ->orderable(false)
                ->searchable(false),

            Column::make('created_at')
                ->title('Registered On'),
        ];
    }

    protected function filename(): string
    {
        return 'ReferralUsersList_' . date('YmdHis');
    }
}