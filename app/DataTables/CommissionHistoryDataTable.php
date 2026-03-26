<?php

namespace App\DataTables;

use App\Models\AffiliateReferral;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CommissionHistoryDataTable extends DataTable
{
    protected $affiliateId;
    protected $referralCode;

    public function __construct()
    {
        $affiliateUser      = Auth::guard('affiliate')->user();
        $this->affiliateId  = $affiliateUser->affiliate->id;
        $this->referralCode = $affiliateUser->affiliate->referral_code;
    }

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('user_name', function ($row) {
                return $row->user
                    ? $row->user->first_name . ' ' . $row->user->last_name
                    : 'N/A';
            })
            ->addColumn('user_email', function ($row) {
                return $row->user ? $row->user->email : 'N/A';
            })
            ->addColumn('order_number', function ($row) {
                return $row->order ? $row->order->order_number : 'N/A';
            })
            ->editColumn('order_amount', function ($row) {
                return number_format($row->order_amount, 2);
            })
            ->editColumn('commission_amount', function ($row) {
                return number_format($row->commission_amount, 2);
            })
            ->editColumn('status', function ($row) {
                return $row->status === 'paid'
                    ? '<span class="badge bg-success">Paid</span>'
                    : '<span class="badge bg-warning">Pending</span>';
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at->timezone('Asia/Kolkata')->format('d M Y, h:i A');
            })

            //  Sorting   
            ->orderColumn('user_name', "(SELECT CONCAT(first_name, ' ', last_name) FROM users WHERE users.id = affiliate_referrals.user_id) $1")
            ->orderColumn('user_email', "(SELECT email FROM users WHERE users.id = affiliate_referrals.user_id) $1")
            ->orderColumn('order_number', "(SELECT order_number FROM orders WHERE orders.id = affiliate_referrals.order_id) $1")
            ->orderColumn('order_amount', 'affiliate_referrals.order_amount $1')
            ->orderColumn('commission_amount', 'affiliate_referrals.commission_amount $1')
            ->orderColumn('status', 'affiliate_referrals.status $1')
            ->orderColumn('created_at', 'affiliate_referrals.created_at $1')

            //  Searching
            ->filterColumn('user_name', function ($query, $keyword) {
                $query->whereHas('user', function ($q) use ($keyword) {
                    $q->where('first_name', 'like', "%{$keyword}%")
                      ->orWhere('last_name', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('user_email', function ($query, $keyword) {
                $query->whereHas('user', function ($q) use ($keyword) {
                    $q->where('email', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('order_number', function ($query, $keyword) {
                $query->whereHas('order', function ($q) use ($keyword) {
                    $q->where('order_number', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('status', function ($query, $keyword) {
                $query->where('affiliate_referrals.status', 'like', "%{$keyword}%");
            })

            ->rawColumns(['status'])
            ->setRowId('id');
    }

    public function query(AffiliateReferral $model): QueryBuilder
    {
        //  Only fetch referrals for current affiliate
        return $model->newQuery()
            ->where('affiliate_id', $this->affiliateId)
            ->with(['user', 'order'])
            ->select('affiliate_referrals.*');
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('commissionhistory-table')
            ->columns($this->getColumns())
            ->ajax([
                'url'  => route('affiliate.commission_history'),
                'type' => 'GET',
            ])
            ->orderBy(7, 'desc') //  created_at = index 7
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

            Column::make('user_name')
                ->title('User Name'),

            Column::make('user_email')
                ->title('Email'),

            Column::make('order_number')
                ->title('Order No'),

            Column::make('order_amount')
                ->title('Order Amount ($)'),

            Column::make('commission_amount')
                ->title('Commission ($)'),

            Column::make('status')
                ->title('Status'),

            Column::make('created_at')
                ->title('Date'),
        ];
    }

    protected function filename(): string
    {
        return 'CommissionHistory_' . date('YmdHis');
    }
}