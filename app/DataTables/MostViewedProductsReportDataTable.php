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

class MostViewedProductsReportDataTable extends DataTable
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
            ->addColumn('total_views', function ($row) {
                return number_format($row->views ?? 0);
            })
            // ->addColumn('status', function ($row) {
            //     return $row->status == 1
            //         ? '<span class="badge bg-success">Active</span>'
            //         : '<span class="badge bg-secondary">Inactive</span>';
            // })

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
            ->orderColumn('total_views', 'views $1')

            //  Searching
            ->filterColumn('product_name', function ($query, $keyword) {
                $query->where('batch_files.title', 'like', "%{$keyword}%");
            })
            ->filterColumn('category_name', function ($query, $keyword) {
                $query->whereHas('category', function ($q) use ($keyword) {
                    $q->where('category_name', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('total_views', function ($query, $keyword) {
                $query->where('views', 'like', "%{$keyword}%");
            })

            ->rawColumns(['status'])
            ->setRowId('id');
    }

    public function query(BatchFile $model): QueryBuilder
    {
        $query = $model->newQuery()
            ->select('batch_files.*')
            ->with('category')
            ->where('views', '>', 0)
            ->orderByDesc('views');

        if (request()->filled('from_date')) {
            $query->whereDate('batch_files.created_at', '>=', request('from_date'));
        }

        if (request()->filled('to_date')) {
            $query->whereDate('batch_files.created_at', '<=', request('to_date'));
        }

        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('mostviewedproductsreport-table')
            ->columns($this->getColumns())
            ->ajax([
                'url' => route('admin.most_viewed_product_report'),
                'type' => 'GET',
                'data' => 'function(d) {
        d.from_date = $("#from_date").val();
        d.to_date   = $("#to_date").val();
    }',
            ])
            ->orderBy(3, 'desc') //  total_views = index 3
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
                // Button::make('excel')->exportOptions(['columns' => ':visible']),
                // Button::make('csv')->exportOptions(['columns'   => ':visible']),
                Button::make('pdf')->exportOptions(['columns' => ':visible']),
                // Button::make('print')->exportOptions(['columns' => ':visible']),
                // Button::raw('reload'),
                // Button::raw('resetTable'),
            ]);
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

            Column::make('total_views')
                ->title('Total Views'),

            // Column::make('status')
            //     ->title('Status'),
        ];
    }

    protected function getExportColumns(): array
    {
        return [
            ['data' => 'DT_RowIndex', 'title' => 'Sr No'],
            ['data' => 'product_name', 'title' => 'Product Name'],
            ['data' => 'category_name', 'title' => 'Category'],
            ['data' => 'total_views', 'title' => 'Total Views'],
            ['data' => 'status', 'title' => 'Status'],
        ];
    }

    protected function filename(): string
    {
        return 'MostViewedProductsReport_' . date('YmdHis');
    }
}