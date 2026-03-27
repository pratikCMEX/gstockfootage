<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UserWiseOrderReportDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('user_name', function ($row) {
                return $row->first_name . ' ' . $row->last_name;
            })
            ->addColumn('total_orders', function ($row) {
                return $row->total_orders ?? 0;
            })
            ->addColumn('total_amount', function ($row) {
                return number_format($row->total_amount ?? 0, 2);
            })
            ->addColumn('completed_orders', function ($row) {
                return $row->completed_orders ?? 0;
            })
            ->addColumn('pending_orders', function ($row) {
                return $row->pending_orders ?? 0;
            })
            ->addColumn('cancelled_orders', function ($row) {
                return $row->cancelled_orders ?? 0;
            })
            ->addColumn('last_order_date', function ($row) {
                return $row->last_order_date
                    ? \Carbon\Carbon::parse($row->last_order_date)->format('d M Y')
                    : 'N/A';
            })

            // Export clean columns
            ->addColumn('export_total_amount', fn($row) => number_format($row->total_amount ?? 0, 2))

            //  Sorting
            ->orderColumn('user_name', 'first_name $1')
            ->orderColumn('total_orders', 'total_orders $1')
            ->orderColumn('total_amount', 'total_amount $1')
            ->orderColumn('completed_orders', 'completed_orders $1')
            ->orderColumn('pending_orders', 'pending_orders $1')
            ->orderColumn('cancelled_orders', 'cancelled_orders $1')
            ->orderColumn('last_order_date', 'last_order_date $1')

            //  Searching
            ->filterColumn('user_name', function ($query, $keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('first_name', 'like', "%{$keyword}%")
                        ->orWhere('last_name', 'like', "%{$keyword}%")
                        ->orWhere('email', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('total_orders', function ($query, $keyword) {
                $query->where('total_orders', 'like', "%{$keyword}%");
            })
            ->filterColumn('total_amount', function ($query, $keyword) {
                $query->where('total_amount', 'like', "%{$keyword}%");
            })
            ->filterColumn('completed_orders', function ($query, $keyword) {
                $query->where('completed_orders', 'like', "%{$keyword}%");
            })
            ->filterColumn('pending_orders', function ($query, $keyword) {
                $query->where('pending_orders', 'like', "%{$keyword}%");
            })
            ->filterColumn('cancelled_orders', function ($query, $keyword) {
                $query->where('cancelled_orders', 'like', "%{$keyword}%");
            })
            ->filterColumn('last_order_date', function ($query, $keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('last_order_date', 'like', "%{$keyword}%")
                        ->orWhereRaw("DATE_FORMAT(last_order_date, '%d %b %Y') like ?", ["%{$keyword}%"]);
                });
            })

            ->rawColumns([])
            ->setRowId('id');
    }

    public function query(User $model): QueryBuilder
    {
        $subQuery = DB::table('users')
            ->select([
                'users.*',
                DB::raw('COUNT(orders.id) as total_orders'),
                DB::raw('SUM(orders.total_amount) as total_amount'),
                DB::raw('SUM(CASE WHEN orders.order_status = "completed" THEN 1 ELSE 0 END) as completed_orders'),
                DB::raw('SUM(CASE WHEN orders.order_status = "pending" THEN 1 ELSE 0 END) as pending_orders'),
                DB::raw('SUM(CASE WHEN orders.order_status = "cancelled" THEN 1 ELSE 0 END) as cancelled_orders'),
                DB::raw('MAX(orders.created_at) as last_order_date'),
            ])
            ->join('orders', 'orders.user_id', '=', 'users.id')
            ->groupBy('users.id');

        //  Date filter
        if (request()->filled('from_date')) {
            $subQuery->whereDate('orders.created_at', '>=', request('from_date'));
        }

        if (request()->filled('to_date')) {
            $subQuery->whereDate('orders.created_at', '<=', request('to_date'));
        }
        if (request()->filled('user_id')) {
            $subQuery->where('users.id', request('user_id'));
        }

        //  Wrap as subquery for searchable aggregated columns
        $query = User::from(DB::raw("({$subQuery->toSql()}) as users"))
            ->mergeBindings($subQuery)
            ->select('users.*');

        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('userwiseorderreport-table')
            ->columns($this->getColumns())
            ->ajax([
                'url' => route('admin.user_wise_order_report'), //  update with your route
                'type' => 'GET',
                'data' => 'function(d) {
                    d.from_date = $("#from_date").val();
                    d.to_date   = $("#to_date").val();
                    d.user_id   = $("#user_id").val();
                }',
            ])
            ->orderBy(2, 'desc') //  total_orders = index 2
            ->selectStyleSingle()
            ->parameters([
                'dom' => 'Blfrtip',
                'lengthChange' => true,
                'lengthMenu' => [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, 'All']
                ],
                'pageLength' => 10,
                'drawCallback' => 'function(settings) {
        let api = this.api();
        let count = api.rows({ filter: "applied" }).data().length;

        let pdfBtn = $(".dt-button").filter(function() {
            return $(this).text().includes("PDF");
        });

        if (count === 0) {
            pdfBtn.hide();
        } else {
            pdfBtn.show();
        }
    }',
            ])
            ->buttons([
                //  Custom PDF button - exports ALL records with filters
                Button::raw([
                    'text' => '<i class="fa fa-file-pdf"></i> PDF',
                    'action' => 'function(e, dt, node, config) {
            let from           = $("#from_date").val();
            let to             = $("#to_date").val();
            let user_id        = $("#user_id").val();
           

            let url = "' . route('admin.user_wise_order_report.export_pdf') . '"
                + "?from_date="      + from
                + "&to_date="        + to
                + "&user_id="        + user_id;
            window.location.href = url;
        }',
                ]),
                 Button::raw([
        'text' => '<i class="fa fa-file-excel"></i> Excel',
        'action' => 'function(e, dt, node, config) {
            let from        = $("#from_date").val();
            let to          = $("#to_date").val();
            let user_id  = $("#user_id").val();

            let url = "' . route('admin.user_wise_order_report.export_excel') . '"
                + "?from_date="   + from
                + "&to_date="     + to
                + "&user_id=" + user_id;

            window.location.href = url;
        }',
    ]),
            ]);
        // ->buttons([
        //     // Button::make('excel')->exportOptions(['columns' => ':visible']),
        //     // Button::make('csv')->exportOptions(['columns'   => ':visible']),
        //     Button::make('pdf')->exportOptions(['columns' => ':visible']),
        //     // Button::make('print')->exportOptions(['columns' => ':visible']),
        //     // Button::raw('reload'),
        //     // Button::raw('resetTable'),
        // ]);
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

            Column::make('email')
                ->title('Email'),

            Column::make('total_orders')
                ->title('Total Orders'),

            Column::make('total_amount')
                ->title('Total Amount ($)'),

            Column::make('completed_orders')
                ->title('Completed'),

            Column::make('pending_orders')
                ->title('Pending'),

            Column::make('cancelled_orders')
                ->title('Cancelled'),

            Column::make('last_order_date')
                ->title('Last Order Date'),
        ];
    }

    protected function getExportColumns(): array
    {
        return [
            ['data' => 'DT_RowIndex', 'title' => 'Sr No'],
            ['data' => 'user_name', 'title' => 'User Name'],
            ['data' => 'email', 'title' => 'Email'],
            ['data' => 'total_orders', 'title' => 'Total Orders'],
            ['data' => 'export_total_amount', 'title' => 'Total Amount'],
            ['data' => 'completed_orders', 'title' => 'Completed'],
            ['data' => 'pending_orders', 'title' => 'Pending'],
            ['data' => 'cancelled_orders', 'title' => 'Cancelled'],
            ['data' => 'last_order_date', 'title' => 'Last Order Date'],
        ];
    }

    protected function filename(): string
    {
        return 'UserWiseOrderReport_' . date('YmdHis');
    }
}