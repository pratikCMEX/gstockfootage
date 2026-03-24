<?php

namespace App\DataTables;

use App\Models\User_subscriptions;
use App\Models\UserSubscriptionReport;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UserSubscriptionReportDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->editColumn('status', function ($row) {
                return match ($row->status) {
                    'active' => '<span class="badge bg-success">Active</span>',
                    'expired' => '<span class="badge bg-danger">Expired</span>',
                    'inactive' => '<span class="badge bg-secondary">Inactive</span>',
                    'cancelled' => '<span class="badge bg-warning">Cancelled</span>',
                    default => '<span class="badge bg-secondary">' . ucfirst($row->status) . '</span>',
                };
            })
            ->editColumn('payment_status', function ($row) {
                return match ($row->payment_status) {
                    'success' => '<span class="badge bg-success">Success</span>',
                    'pending' => '<span class="badge bg-warning">Pending</span>',
                    'failed' => '<span class="badge bg-danger">Failed</span>',
                    default => '<span class="badge bg-secondary">' . ucfirst($row->payment_status) . '</span>',
                };
            })
            ->editColumn('amount', function ($row) {
                return $row->currency . ' ' . number_format($row->amount, 2);
            })
            ->editColumn('start_date', function ($row) {
                return $row->start_date ? \Carbon\Carbon::parse($row->start_date)->format('d M Y') : 'N/A';
            })
            ->editColumn('end_date', function ($row) {
                return $row->end_date ? \Carbon\Carbon::parse($row->end_date)->format('d M Y') : 'N/A';
            })
            ->addColumn('user_name', function ($row) {
                return $row->user ? $row->user->first_name . ' ' . $row->user->last_name : 'N/A';
            })
            ->addColumn('plan_name', function ($row) {
                return $row->subscription ? $row->subscription->name : 'N/A';
            })
            ->filterColumn('user_name', function ($query, $keyword) {
                $query->whereHas('user', function ($q) use ($keyword) {
                    $q->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$keyword}%"]);
                });
            })

            ->filterColumn('plan_name', function ($query, $keyword) {
                $query->whereHas('subscription', function ($q) use ($keyword) {
                    $q->where('name', 'LIKE', "%{$keyword}%");
                });
            })
            ->orderColumn('user_name', function ($query, $order) {
                $query->whereHas('user', function ($q) use ($order) {
                    $q->orderBy('first_name', $order);
                });
            })

            ->orderColumn('plan_name', function ($query, $order) {
                $query->whereHas('subscription', function ($q) use ($order) {
                    $q->orderBy('name', $order);
                });
            })

            ->addColumn('export_status', fn($row) => ucfirst($row->status))
            ->addColumn('export_payment_status', fn($row) => ucfirst($row->payment_status))
            ->addColumn('export_amount', fn($row) => $row->currency . ' ' . number_format($row->amount, 2))
            ->rawColumns(['status', 'payment_status'])
            ->setRowId('id');
    }

    // public function query(User_subscriptions $model): QueryBuilder
    // {
    //     return $model->newQuery()
    //         ->with(['user', 'subscription'])
    //         ->select('user_subscriptions.*');
    // }

    public function query(User_subscriptions $model): QueryBuilder
    {
        $query = $model->newQuery()
            ->with(['user', 'subscription'])
            ->select('user_subscriptions.*');

        if (request()->filled('from_date')) {
            $query->whereDate('start_date', '>=', request('from_date'));
        }

        if (request()->filled('to_date')) {
            $query->whereDate('start_date', '<=', request('to_date'));
        }

        if (request()->filled('status')) {
            $query->where('status', request('status'));
        }

        //  Payment status filter
        if (request()->filled('payment_status')) {
            $query->where('payment_status', request('payment_status'));
        }
        return $query;
    }
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('usersubscriptionreport-table')
            ->columns($this->getColumns())
            ->ajax([
                'url' => route('admin.user_subscriptions_report'),
                'type' => 'GET',
                'data' => 'function(d) {
                    d.from_date = $("#from_date").val();
                    d.to_date   = $("#to_date").val();
                     d.status   = $("#status").val();   
                    d.payment_status = $("#payment_status").val(); 
                }',
            ])
            ->orderBy(3, 'desc')
            ->selectStyleSingle()
            ->parameters([
                'dom' => 'Blfrtip',
                'lengthChange' => true,
                'lengthMenu' => [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, 'All']
                ],
                'pageLength' => 10,
            ])
            ->buttons([
                Button::raw([
                    'text' => '<i class="fa fa-file-pdf"></i> PDF',
                    'action' => 'function(e, dt, node, config) {
            let from           = $("#from_date").val();
            let to             = $("#to_date").val();
            let status   = $("#status").val();
            let payment_status = $("#payment_status").val();

            let url = "' . route('admin.user_subscriptions_report.export_pdf') . '"
                + "?from_date="      + from
                + "&to_date="        + to
                + "&status="   + status
                + "&payment_status=" + payment_status;

            window.location.href = url;
        }',
                ]),
            ]);
        // ->buttons([
        //     Button::make('pdf')->exportOptions(['columns' => ':visible']),
        // ]);
    }
    public function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex')
                ->title('Sr No')
                ->exportable(false)
                ->printable(false)
                ->orderable(false)
                ->width(50)
                ->addClass('text-center'),

            Column::make('user_name')
                ->title('User Name'),


            Column::make('plan_name')
                ->title('Plan Name'),


            Column::make('start_date')
                ->title('Start Date'),

            Column::make('end_date')
                ->title('End Date'),

            Column::make('total_clips')
                ->title('Total Clips'),

            Column::make('used_clips')
                ->title('Used Clips'),

            Column::make('remaining_clips')
                ->title('Remaining Clips'),

            Column::make('amount')
                ->title('Amount'),

            Column::make('status')
                ->title('Status'),

            Column::make('payment_status')
                ->title('Payment Status'),
        ];
    }
    // public function getColumns(): array
    // {
    //     return [
    //         Column::computed('DT_RowIndex')
    //             ->title('Sr No')
    //             ->exportable(false)
    //             ->printable(false)
    //             ->orderable(false)
    //             ->width(50)
    //             ->addClass('text-center'),

    //         Column::make('user_name')
    //             ->title('User Name')
    //             ->name('user.name'),

    //         Column::make('plan_name')
    //             ->title('Plan Name')
    //             ->name('subscription.name'),

    //         Column::make('start_date')
    //             ->title('Start Date'),

    //         Column::make('end_date')
    //             ->title('End Date'),

    //         Column::make('total_clips')
    //             ->title('Total Clips'),

    //         Column::make('used_clips')
    //             ->title('Used Clips'),

    //         Column::make('remaining_clips')
    //             ->title('Remaining Clips'),

    //         Column::make('amount')
    //             ->title('Amount'),

    //         Column::make('status')
    //             ->title('Status'),

    //         Column::make('payment_status')
    //             ->title('Payment Status'),


    //     ];
    // }

    protected function getExportColumns(): array
    {
        return [
            ['data' => 'DT_RowIndex', 'title' => 'Sr No'],
            ['data' => 'user_name', 'title' => 'User Name'],
            ['data' => 'plan_name', 'title' => 'Plan Name'],
            ['data' => 'start_date', 'title' => 'Start Date'],
            ['data' => 'end_date', 'title' => 'End Date'],
            ['data' => 'total_clips', 'title' => 'Total Clips'],
            ['data' => 'used_clips', 'title' => 'Used Clips'],
            ['data' => 'remaining_clips', 'title' => 'Remaining Clips'],
            ['data' => 'export_amount', 'title' => 'Amount'],
            ['data' => 'export_status', 'title' => 'Status'],
            ['data' => 'export_payment_status', 'title' => 'Payment Status'],
        ];
    }

    protected function filename(): string
    {
        return 'UserSubscriptionReport_' . date('YmdHis');
    }
}