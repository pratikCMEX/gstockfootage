<?php

namespace App\DataTables;

use App\Models\BatchFile;
use App\Models\ProductPriority;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProductPriorityDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<ProductPriority> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->setRowId('id')
            ->addColumn('category', function ($row) {
                return $row->category?->category_name ?? '-';
            })
            ->addColumn('subcategory', function ($row) {
                return $row->subcategory?->name ?? '-';
            })
            ->addColumn('collection', function ($row) {
                return $row->collection?->name ?? '-';
            })
            ->editColumn('type', function ($row) {
                return ($row->type == 'image') ? 'Image' : 'Video';
            })
            ->addColumn('preview', function ($row) {
                $thumbnail = $row->thumbnail_path
                    ? Storage::disk('s3')->url($row->thumbnail_path)
                    : asset('assets/admin/images/demo_thumbnail.png');

                $videoUrl = Storage::disk('s3')->url($row->file_path); // high_path == file_path
    
                if ($row->type === 'image') {

                    return '<img src="' . Storage::disk('s3')->url($row->low_path) . '"
                        class="preview-image"
                        data-src="' . Storage::disk('s3')->url($row->file_path) . '"
                        width="80"
                        height="80"
                        style="cursor:pointer" />';
                }

                return '<div class="video-thumbnail-wrapper position-relative d-inline-block">  
                            <img src="' . $thumbnail . '" 
                            width="100" height="100" 
                            class="video-thumbnail rounded cursor-pointer" 
                            data-video="' . $videoUrl . '" 
                            alt="Video Thumbnail">
                              <i class="ti ti-player-play play-icon video-thumbnail" data-video="' . $videoUrl . '" ></i>
                        </div>';
            })
            ->addColumn('preview', function ($row) {
                $thumbnail = $row->thumbnail_path
                    ? Storage::disk('s3')->url($row->thumbnail_path)
                    : asset('assets/admin/images/demo_thumbnail.png');

                $videoUrl = Storage::disk('s3')->url($row->file_path); // high_path == file_path
    
                if ($row->type === 'image') {

                    return '<img src="' . Storage::disk('s3')->url($row->low_path) . '"
                        class="preview-image"
                        data-src="' . Storage::disk('s3')->url($row->file_path) . '"
                        width="80"
                        height="80"
                        style="cursor:pointer" />';
                }

                return '<div class="video-thumbnail-wrapper position-relative d-inline-block">  
                            <img src="' . $thumbnail . '" 
                            width="100" height="100" 
                            class="video-thumbnail rounded cursor-pointer" 
                            data-video="' . $videoUrl . '" 
                            alt="Video Thumbnail">
                              <i class="ti ti-player-play play-icon video-thumbnail" data-video="' . $videoUrl . '" ></i>
                        </div>';
            })

            // ->addColumn('display_status', function ($row) {
            //     $checked = $row->is_display ? 'checked' : '';
            //     return '
            //         <div class="form-check form-switch">
            //             <input class="form-check-input toggle-display"
            //                    type="checkbox"
            //                    data-id="' . $row->id . '"
            //                    ' . $checked . '>
            //         </div>
            //     ';
            // })

            ->addColumn('drag', function ($row) {
                return '<i class="bi bi-arrows-move drag-handle"></i>';
            })
            ->orderColumn('category', function ($query, $order) {
                $query->orderBy(
                    \App\Models\Category::select('category_name')
                        ->whereColumn('categories.id', 'batch_files.category_id')
                        ->limit(1),
                    $order
                );
            })

            ->orderColumn('subcategory', function ($query, $order) {
                $query->orderBy(
                    \App\Models\SubCategory::select('name')
                        ->whereColumn('sub_categories.id', 'batch_files.subcategory_id')
                        ->limit(1),
                    $order
                );
            })

            ->orderColumn('collection', function ($query, $order) {
                $query->orderBy(
                    \App\Models\Collection::select('name')
                        ->whereColumn('collections.id', 'batch_files.collection_id')
                        ->limit(1),
                    $order
                );
            })


            ->rawColumns([

                'category',
                'subcategory',
                'collection',
                'type',
                'preview',
                'name',
                'price',
                'description',
                'display_status',
                'created_at',

            ]);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<BatchFile>
     */
    public function query(BatchFile $model): QueryBuilder
    {
        $query = $model->newQuery()
            ->with(['category', 'subcategory', 'collection'])->where('batch_id', null);

        $category = request()->category;
        $subcategory = request()->subcategory;
        $collection = request()->collections;
        $type = request()->type;

        if ($category) {
            $query->where('category_id', $category);
        }

        if ($subcategory) {
            $query->where('subcategory_id', $subcategory);
        }

        if ($collection) {
            $query->where('collection_id', $collection);
        }

        if ($type !== null && $type !== '') {
            $query->where('type', $type);
        }
        $query->orderBy('priority', 'asc');
        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('productpriority-table')
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
                Button::make('reload')
            ])
            ->parameters([
                'ordering' => false,
                'searching' => false,
                'paging' => false
            ]);

    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex')
                ->title('Priority')
                ->searchable(false)
                ->orderable(false),
            Column::make('category')->title('Category'),
            Column::make('subcategory')->title('Subcategory'),
            Column::make('collection')->title('Collection')->orderable(true),
            Column::make('type')->title('Type'),
            Column::make('preview')->title('Preview')->orderable(false),
            Column::make('title')->title('Name')->orderable(true),
            Column::make('price')->title('Price'),
            Column::make('description')->title('Description'),
            Column::make('keywords')->title('Tags'),
            // Column::make('display_status')->title('Display')->orderable(false),
            // Column::make('drag')->title('Actions')->orderable(false),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'ProductPriority_' . date('YmdHis');
    }
}
