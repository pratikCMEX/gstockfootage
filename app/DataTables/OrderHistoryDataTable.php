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
            ->addIndexColumn() // ✅ sr no
            ->addColumn('action', function ($row) {
                return '<a href="' . route('admin.order_detail', encrypt($row->id)) . '" 
                            class="btn btn-sm btn-info" title="View Detail">
                          <i class="fa-solid fa-info"></i>
                        </a>';
            })
            // ->addColumn('user_name', function ($row) {
            //     return $row->user ? $row->user->name : 'N/A';
            // })
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
                return $row->created_at->format('d M Y, h:i A');
            })
            ->rawColumns(['action', 'payment_status', 'order_status']) // ✅ render HTML
            ->setRowId('id');
    }

    public function query(Order $model): QueryBuilder
    {
        return $model->newQuery()
            ->with('user')
            ->select('orders.*')
            ->latest('id');
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('orderhistory-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload'),
            ]);
    }

    public function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex')
                ->title('Sr No')
                ->exportable(false)
                ->printable(false)
                ->width(50)
                ->addClass('text-center'),



            // Column::computed('user_name')
            //     ->title('User Name'),

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
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'OrderHistory_' . date('YmdHis');
    }
}