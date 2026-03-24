<?php

namespace App\DataTables;

use App\Models\BatchFile;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class MostSoldProductReportDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('product_name', function ($row) {
                return $row->title ?? 'N/A';
            })
            ->addColumn('category_name', function ($row) {
                return $row->category ? $row->category->category_name : 'N/A';
            })
            ->addColumn('total_orders', function ($row) {
                return $row->total_orders ?? 0;
            })
            ->addColumn('total_revenue', function ($row) {
                return '$' . number_format($row->total_revenue ?? 0, 2);
            })
            ->addColumn('export_total_revenue', fn($row) => number_format($row->total_revenue ?? 0, 2))

            //  Sorting
            ->orderColumn('product_name', 'batch_files.title $1')
            ->orderColumn('category_name', function ($query, $order) {
                $query->orderBy(
                    Category::select('category_name')
                        ->whereColumn('categories.id', 'batch_files.category_id')
                        ->limit(1),
                    $order
                );
            })
            ->orderColumn('total_orders', 'total_orders $1')
            ->orderColumn('total_revenue', 'total_revenue $1')

            // Searching
            ->filterColumn('product_name', function ($query, $keyword) {
                $query->where('batch_files.title', 'like', "%{$keyword}%");
            })
            ->filterColumn('category_name', function ($query, $keyword) {
                $query->whereHas('category', function ($q) use ($keyword) {
                    $q->where('category_name', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('total_orders', function ($query, $keyword) {
                $query->where('total_orders', 'like', "%{$keyword}%"); // ✅ where instead of having
            })
            ->filterColumn('total_revenue', function ($query, $keyword) {
                $query->where('total_revenue', 'like', "%{$keyword}%"); // ✅ where instead of having
            })

            ->rawColumns([])
            ->setRowId('id');
    }

    public function query(BatchFile $model): QueryBuilder
    {
        //  Wrap as subquery so having columns become searchable
        $subQuery = DB::table('batch_files')
            ->select([
                'batch_files.*',
                DB::raw('COUNT(order_details.id) as total_orders'),
                DB::raw('SUM(orders.total_amount) as total_revenue'),
            ])
            ->join('order_details', 'order_details.product_id', '=', 'batch_files.id')
            ->join('orders', 'orders.id', '=', 'order_details.order_id')
            ->groupBy('batch_files.id');

        if (request()->filled('from_date')) {
            $subQuery->whereDate('orders.created_at', '>=', request('from_date'));
        }

        if (request()->filled('to_date')) {
            $subQuery->whereDate('orders.created_at', '<=', request('to_date'));
        }

        //  Wrap in outer query so total_orders/total_revenue become regular columns
        $query = BatchFile::from(DB::raw("({$subQuery->toSql()}) as batch_files"))
            ->mergeBindings($subQuery)
            ->select('batch_files.*')
            ->with('category');

        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('mostsoldproductreport-table')
            ->columns($this->getColumns())
            ->ajax([
                'url' => route('admin.most_sold_product_report'),
                'type' => 'GET',
                'data' => 'function(d) {
                    d.from_date = $("#from_date").val();
                    d.to_date   = $("#to_date").val();
                }',
            ])
            ->orderBy(3, 'desc') //  total_orders = index 3, highest sold first
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
           

            let url = "' . route('admin.most_sold_product_report.export_pdf') . '"
                + "?from_date="      + from
                + "&to_date="        + to
              
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

            Column::make('product_name')
                ->title('Product Name'),

            Column::make('category_name')
                ->title('Category'),

            Column::make('total_orders')
                ->title('Total Orders'),

            Column::make('total_revenue')
                ->title('Total Revenue'),
        ];
    }

    protected function getExportColumns(): array
    {
        return [
            ['data' => 'DT_RowIndex', 'title' => 'Sr No'],
            ['data' => 'product_name', 'title' => 'Product Name'],
            ['data' => 'category_name', 'title' => 'Category'],
            ['data' => 'total_orders', 'title' => 'Total Orders'],
            ['data' => 'export_total_revenue', 'title' => 'Total Revenue'],
        ];
    }

    protected function filename(): string
    {
        return 'MostSoldProductReport_' . date('YmdHis');
    }
}