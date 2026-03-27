<?php

namespace App\DataTables;

use App\Models\Cart;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class LiveCartReportDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('user_name', function ($row) {
                return $row->user ? $row->user->first_name . ' ' . $row->user->last_name : '-';
            })
            ->addColumn('product_name', function ($row) {
                return $row->product ? $row->product->title : '-';
            })
            ->addColumn('total_items', function ($row) {
                return $row->qty;
            })
            ->addColumn('total_amount', function ($row) {
                $total = $row->qty * ($row->product->price ?? 0);
                return number_format($total, 2);
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at ? $row->created_at->format('d M Y, h:i A') : '-';
            })

            //  Sorting
            ->orderColumn('user_name', function ($query, $order) {
                $query->join('users', 'users.id', '=', 'carts.user_id')
                    ->orderBy('users.first_name', $order);
            })
            ->orderColumn('product_name', function ($query, $order) {
                $query->join('batch_files', 'batch_files.id', '=', 'carts.product_id')
                    ->orderBy('batch_files.title', $order);
            })
            ->orderColumn('total_items', 'carts.qty $1')
            ->orderColumn('total_amount', function ($query, $order) {
                $query->orderByRaw("(carts.qty * (SELECT price FROM batch_files WHERE batch_files.id = carts.product_id)) $order");
            })
            ->orderColumn('created_at', 'carts.created_at $1')

            //  Searching
            ->filterColumn('user_name', function ($query, $keyword) {
                $query->whereHas('user', function ($q) use ($keyword) {
                    $q->where('first_name', 'like', "%{$keyword}%")
                        ->orWhere('last_name', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('product_name', function ($query, $keyword) {
                $query->whereHas('product', function ($q) use ($keyword) {
                    $q->where('title', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('total_items', function ($query, $keyword) {
                $query->where('carts.qty', 'like', "%{$keyword}%");
            })
            ->filterColumn('total_amount', function ($query, $keyword) {
                $query->whereRaw("(carts.qty * (SELECT price FROM batch_files WHERE batch_files.id = carts.product_id)) like ?", ["%{$keyword}%"]);
            })
            ->filterColumn('created_at', function ($query, $keyword) {
                $query->whereRaw("DATE_FORMAT(carts.created_at, '%d %b %Y') like ?", ["%{$keyword}%"]);
            })

            ->rawColumns([])
            ->setRowId('id');
    }

    public function query(Cart $model): QueryBuilder
    {
        $query = $model->newQuery()
            ->with(['product', 'user'])
            ->select('carts.*');

        if (request()->filled('from_date')) {
            $query->whereDate('carts.created_at', '>=', request('from_date'));
        }

        if (request()->filled('to_date')) {
            $query->whereDate('carts.created_at', '<=', request('to_date'));
        }
        if (request()->filled('user_id')) {
            $query->where('carts.user_id', request('user_id'));
        }
        if (request()->filled('product_id')) {
            $query->where('carts.product_id', request('product_id'));
        }

        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('livecartreport-table')
            ->columns($this->getColumns())
            ->ajax([
                'url' => route('admin.live_cart_report'), // update with your route
                'type' => 'GET',
                'data' => 'function(d) {
                    d.from_date = $("#from_date").val();
                    d.to_date   = $("#to_date").val();
                    d.user_id=$("#user_id").val();
                    d.product_id=$("#product_id").val();
                }',
            ])
            ->orderBy(5, 'desc')
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
                    'text' => '<i class="fa fa-file-pdf"></i> PDF',
                    'action' => 'function(e, dt, node, config) {
            let from           = $("#from_date").val();
            let to             = $("#to_date").val();
             let user_id             = $("#user_id").val();
             let product_id             = $("#product_id").val();
           

            let url = "' . route('admin.live_cart_report.export_pdf') . '"
                + "?from_date="      + from
                + "&to_date="        + to
                + "&user_id="        + user_id
                + "&product_id="     + product_id
              
            window.location.href = url;
        }',
                ]),
                   Button::raw([
        'text' => '<i class="fa fa-file-excel"></i> Excel',
        'attr'      => ['class' => 'dt-button my-excel-btn btn btn-success'],
        'action' => 'function(e, dt, node, config) {
            let from        = $("#from_date").val();
            let to          = $("#to_date").val();
            let product_id  = $("#product_id").val();
            let user_id  = $("#user_id").val();

            let url = "' . route('admin.live_cart_report.export_excel') . '"
                + "?from_date="   + from
                + "&to_date="     + to
                + "&product_id="  + product_id
                + "&user_id=" + user_id;

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
                ->title('Sr. No.')
                ->exportable(false)
                ->printable(false)
                ->orderable(false)
                ->width(50)
                ->addClass('text-center'),

            Column::make('user_name')
                ->title('User Name'),

            Column::make('product_name')
                ->title('Product Name'),

            Column::make('total_items')
                ->title('Total Items'),

            Column::make('total_amount')
                ->title('Total Amount ($)'),

            Column::make('created_at')
                ->title('Date'),
        ];
    }

    protected function getExportColumns(): array
    {
        return [
            ['data' => 'DT_RowIndex', 'title' => 'Sr No'],
            ['data' => 'user_name', 'title' => 'User Name'],
            ['data' => 'product_name', 'title' => 'Products In Cart'],
            ['data' => 'total_items', 'title' => 'Total Items'],
            ['data' => 'total_amount', 'title' => 'Total Amount'],
            ['data' => 'created_at', 'title' => 'Date'],
        ];
    }

    protected function filename(): string
    {
        return 'LiveCartReport_' . date('YmdHis');
    }
}