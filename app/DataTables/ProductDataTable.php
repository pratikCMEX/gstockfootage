<?php

namespace App\DataTables;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Http\Request;

class ProductDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $counter = 1;

        return datatables()
            ->eloquent($query)

            ->addColumn('no', function () use (&$counter) {
                return $counter++;
            })

            ->filter(function ($query) {
                if ($this->request->has('search')) {
                    $keyword = $this->request->get('search')['value'];

                    $query->where(function ($q) use ($keyword) {
                        $q->where('name', 'LIKE', "%{$keyword}%")
                            ->orWhere('price', 'LIKE', "%{$keyword}%")
                            ->orWhere('description', 'LIKE', "%{$keyword}%")
                            ->orWhere('tags', 'LIKE', "%{$keyword}%")
                            ->orWhereHas('category', function ($cat) use ($keyword) {
                                $cat->where('category_name', 'LIKE', "%{$keyword}%");
                            });
                    });
                }
            })

            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" class="row-checkbox" value="' . $row->id . '">';
            })

            ->addColumn('category', function ($row) {
                return $row->category?->category_name ?? '-';
            })

            ->addColumn('type', function ($row) {
                return ($row->type == '0') ? 'Image' : 'Video';
            })

            ->addColumn('preview', function ($row) {
                $thumbnail = asset('uploads/videos/thumbnails/' . $row->thumbnail_path);
                if ($row->thumbnail_path == "") {
                    $thumbnail = asset('assets/admin/images/demo_thumbnail.png');
                }
                $videoUrl = asset('uploads/videos/high/' . $row->high_path);

                if ($row->type === '0') {
                    return '<img src="' . asset('uploads/images/low/' . $row->low_path) . '"
                                             class="preview-image" 
                        data-src="' . asset('uploads/images/high/' . $row->high_path) . '"
                        width="80" height="80" style="cursor:pointer" />';
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
            ->addColumn('name', function ($row) {
                return $row->name;
            })
            ->addColumn('price', function ($row) {
                return $row->price;
            })
            ->addColumn('description', function ($row) {
                return $row->description;
            })
            ->addColumn('tags', function ($row) {
                return $row->tags;
            })

            ->addColumn('display_status', function ($row) {
                $checked = $row->is_display ? 'checked' : '';
                return '
                    <div class="form-check form-switch">
                        <input class="form-check-input toggle-display"
                               type="checkbox"
                               data-id="' . $row->id . '"
                               ' . $checked . '>
                    </div>
                ';
            })
            ->addColumn('created_at', function ($row) {
                return $row->created_at;
            })
            ->addColumn('actions', function ($row) {
                $edit = route('admin.product_edit', encrypt($row->id));

                return '
                <div class="d-flex gap-2">
                    <a href="' . $edit . '" class="btn btn-primary btn-sm">
                        <i class="ti ti-edit"></i>
                    </a>

                    <button class="btn btn-danger btn-sm deleteProduct"
                        data-id="' . encrypt($row->id) . '">
                        <i class="ti ti-trash"></i>
                    </button>
                </div>';
            })

            ->rawColumns([
                'checkbox',
                'category',
                'type',
                'preview',
                'name',
                'price',
                'description',
                'display_status',
                'created_at',
                'actions'
            ]);
    }

    public function query(Product $model, Request $request): QueryBuilder
    {
        return $model
            ->with('category')
            ->latest();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('products-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reload'),
            ]);
    }

    public function getColumns(): array
    {
        return [
            Column::make('checkbox')
                ->title('<input type="checkbox" id="select-all">')
                ->orderable(false)
                ->searchable(false),

            Column::make('no')->title('No')->orderable(false),

            Column::make('category')->title('Category'),

            Column::make('type')->title('Type'),

            Column::make('preview')->title('Preview')->orderable(false),

            Column::make('name')->title('Name'),

            Column::make('price')->title('Price'),

            Column::make('description')->title('Description'),

            Column::make('tags')->title('Tags')->orderable(false),

            Column::make('display_status')->title('Display')->orderable(false),

            Column::make('created_at')->title('Created'),

            Column::make('actions')->title('Actions')->orderable(false),
        ];
    }

    protected function filename(): string
    {
        return 'Products_' . date('YmdHis');
    }
}
