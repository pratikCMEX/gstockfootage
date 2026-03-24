<?php

namespace App\DataTables;

use App\Models\Order;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class OrderHistoryDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return '<a href="' . route('admin.order_detail', encrypt($row->id)) . '"
                            class="btn btn-sm btn-info" title="View Detail">
                          <i class="fa-solid fa-info"></i>
                        </a>';
            })
            ->editColumn('payment_status', function ($row) {
                return match ($row->payment_status) {
                    'paid' => '<span class="badge bg-success">Paid</span>',
                    'pending' => '<span class="badge bg-warning">Pending</span>',
                    'failed' => '<span class="badge bg-danger">Failed</span>',
                    default => '<span class="badge bg-secondary">' . ucfirst($row->payment_status) . '</span>',
                };
            })
            ->editColumn('order_status', function ($row) {
                return match ($row->order_status) {
                    'completed' => '<span class="badge bg-success">Completed</span>',
                    'pending' => '<span class="badge bg-warning">Pending</span>',
                    'cancelled' => '<span class="badge bg-danger">Cancelled</span>',
                    'processing' => '<span class="badge bg-info">Processing</span>',
                    default => '<span class="badge bg-secondary">' . ucfirst($row->order_status) . '</span>',
                };
            })
            ->editColumn('total_amount', function ($row) {
                return '$' . number_format($row->total_amount, 2);
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at->timezone('Asia/Kolkata')->format('d M Y, h:i A');
            })
            //  Clean columns for export (no HTML, no $ sign)
            ->addColumn('export_order_status', fn($row) => ucfirst($row->order_status))
            ->addColumn('export_payment_status', fn($row) => ucfirst($row->payment_status))
            ->addColumn('export_total_amount', fn($row) => number_format($row->total_amount, 2))
            ->rawColumns(['action', 'payment_status', 'order_status'])
            ->setRowId('id')
            ->only(['DT_RowIndex', 'email', 'order_number', 'total_amount', 'order_status', 'payment_status', 'created_at', 'action', 'export_order_status', 'export_payment_status', 'export_total_amount']);
    }

    public function query(Order $model): QueryBuilder
    {
        $query = $model->newQuery()
            ->with('user')
            ->select('orders.*');

        if (request()->filled('from_date')) {
            $query->whereDate('created_at', '>=', request('from_date'));
        }

        if (request()->filled('to_date')) {
            $query->whereDate('created_at', '<=', request('to_date'));
        }

        if (request()->filled('order_status')) {
            $query->where('order_status', request('order_status'));
        }

        if (request()->filled('payment_status')) {
            $query->where('payment_status', request('payment_status'));
        }

        return $query;
    }

    // public function html(): HtmlBuilder
    // {
    //     return $this->builder()
    //         ->setTableId('orderhistory-table')
    //         ->columns($this->getColumns())
    //         ->minifiedAjax()
    //         ->orderBy(6, 'desc') //  created_at column index = 6, latest first
    //         ->selectStyleSingle()
    //         ->buttons([
    //             Button::make('excel'),
    //             Button::make('csv'),
    //             Button::make('pdf'),
    //             Button::make('print'),
    //             Button::make('reset'),
    //             Button::make('reload'),
    //         ]);
    // }
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('orderhistory-table')
            ->columns($this->getColumns())
            ->ajax([
                'url' => route('admin.order_history'),
                'type' => 'GET',
                'data' => 'function(d) {
                d.from_date = $("#from_date").val();
                d.to_date   = $("#to_date").val();
                d.order_status   = $("#order_status").val();   
                d.payment_status = $("#payment_status").val();
            }',
            ])
            ->orderBy(6, 'desc')
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
    //  Custom PDF button - exports ALL records with filters
    Button::raw([
        'text'   => '<i class="fa fa-file-pdf"></i> PDF',
        'action' => 'function(e, dt, node, config) {
            let from           = $("#from_date").val();
            let to             = $("#to_date").val();
            let order_status   = $("#order_status").val();
            let payment_status = $("#payment_status").val();

            let url = "' . route('admin.order_history.export_pdf') . '"
                + "?from_date="      + from
                + "&to_date="        + to
                + "&order_status="   + order_status
                + "&payment_status=" + payment_status;

            window.location.href = url;
        }',
    ]),
]);
            // ->buttons([
            //     //  Exclude last column (action) from export using column index
            //     // Button::make('excel')->exportOptions(['columns' => [0, 1, 2, 3, 4, 5, 6]]),
            //     // Button::make('csv')->exportOptions(['columns'   => [0, 1, 2, 3, 4, 5, 6]]),
            //     Button::make('pdf')->exportOptions([
            //         'columns' => [0, 1, 2, 3, 4, 5, 6],
            //         'modifier' => [
            //             'page' => 'all',
            //             'search' => 'applied',
            //             'order' => 'applied',
            //         ],
            //     ]),
            //     // Button::make('print')->exportOptions(['columns' => [0, 1, 2, 3, 4, 5, 6]]),
            //     //  Fixed raw button syntax

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

            Column::make('email')
                ->title('Email'),

            Column::make('order_number')
                ->title('Order Number'),

            Column::make('total_amount')
                ->title('Total Amount'),

            Column::make('order_status')
                ->title('Order Status'),

            Column::make('payment_status')
                ->title('Payment Status'),

            Column::make('created_at')
                ->title('Date'),

            Column::computed('action')
                ->title('Action')
                ->exportable(false)
                ->printable(false)
                ->orderable(false)
                ->width(60)
                ->addClass('text-center notexport'),

        ];
    }

    // ✅ Override export columns to use clean data (no HTML badges)
    protected function getExportColumns(): array
    {
        return [
            ['data' => 'DT_RowIndex', 'title' => 'Sr No'],
            ['data' => 'email', 'title' => 'Email'],
            ['data' => 'order_number', 'title' => 'Order Number'],
            ['data' => 'export_total_amount', 'title' => 'Total Amount'],
            ['data' => 'export_order_status', 'title' => 'Order Status'],
            ['data' => 'export_payment_status', 'title' => 'Payment Status'],
            ['data' => 'created_at', 'title' => 'Date'],
        ];
    }

    protected function filename(): string
    {
        return 'OrderHistory_' . date('YmdHis');
    }
}