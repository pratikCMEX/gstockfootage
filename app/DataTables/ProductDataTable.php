<?php

namespace App\DataTables;

use App\Models\BatchFile;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $counter = 1;

        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->filter(function ($query) {
                if ($this->request->has('search')) {
                    $keyword = $this->request->get('search')['value'];

                    $query->where(function ($q) use ($keyword) {
                        $q->where('title', 'LIKE', "%{$keyword}%")
                            ->orWhere('price', 'LIKE', "%{$keyword}%")
                            ->orWhere('description', 'LIKE', "%{$keyword}%")
                            ->orWhere('keywords', 'LIKE', "%{$keyword}%")
                            ->orWhereHas('category', function ($cat) use ($keyword) {
                                $cat->where('category_name', 'LIKE', "%{$keyword}%");
                            })

                            ->orWhereHas('subcategory', function ($sub) use ($keyword) {
                                $sub->where('name', 'LIKE', "%{$keyword}%");
                            })
                            ->orWhereHas('collection', function ($collection) use ($keyword) {
                                $collection->where('name', 'LIKE', "%{$keyword}%");
                            });
                    });
                }
            })

            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" class="form-check-input row-checkbox" value="' . $row->id . '">';
            })

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

                    return '<div class="product-img-video"><img src="' . Storage::disk('s3')->url($row->low_path) . '"
                        class="preview-image"
                        data-src="' . Storage::disk('s3')->url($row->file_path) . '"
                        width="80"
                        height="80"
                        style="cursor:pointer" /> </div>';
                }

                return '<div class="video-thumbnail-wrapper product-img-video position-relative d-inline-block">  
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
            ->orderColumn('category', function ($query, $order) {
                $query->orderBy(
                    \App\Models\Category::select('category_name')
                        ->whereColumn('categories.id', 'products.category_id')
                        ->limit(1),
                    $order
                );
            })

            ->orderColumn('subcategory', function ($query, $order) {
                $query->orderBy(
                    \App\Models\SubCategory::select('name')
                        ->whereColumn('sub_categories.id', 'products.subcategory_id')
                        ->limit(1),
                    $order
                );
            })

            ->orderColumn('collection', function ($query, $order) {
                $query->orderBy(
                    \App\Models\Collection::select('name')
                        ->whereColumn('collections.id', 'products.collection_id')
                        ->limit(1),
                    $order
                );
            })

            ->rawColumns([
                'checkbox',
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
                'actions'
            ]);
    }

    // public function query(Product $model, Request $request): QueryBuilder
    // {
    //     return $model
    //         ->with('category')
    //         ->latest();
    // }
    // public function query(Product $model)
    // {
    //     $query = $model->newQuery()
    //         ->with(['category', 'subcategory', 'collection']);

    //     $category = request()->category;
    //     $subcategory = request()->subcategory;
    //     $collection = request()->collections;
    //     $type=request()->type;

    //     if ($category || $subcategory || $collection || $type) {
    //         $query->where(function ($q) use ($category, $subcategory, $collection,$type) {
    //             if ($category) {
    //                 $q->orWhere('category_id', $category);
    //             }
    //             if ($subcategory) {
    //                 $q->orWhere('subcategory_id', $subcategory);
    //             }
    //             if ($collection) {
    //                 $q->orWhere('collection_id', $collection);
    //             }
    //             if ($type) {
    //                 $q->orWhere('type', $type);
    //             }
    //         });
    //     }

    //     return $query;
    // }
    public function query(BatchFile $model)
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






    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('products-table')
            ->columns($this->getColumns())
            ->ajax([
                'url' => route('admin.product'), // your current route
                'data' => 'function(d) {
                d.category = $("#categories").val();
                d.subcategory = $("#subcategory").val();
                d.collections = $("#collections").val();
                d.type=$("#type").val();
            }'
            ])
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
                ->title('<input type="checkbox" class="form-check-input" id="select-all">')
                ->orderable(false)
                ->searchable(false),

            Column::computed('DT_RowIndex')
                ->title('No')
                ->orderable(false)
                ->searchable(false),

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
            Column::make('actions')->title('Actions')->orderable(false),
        ];
    }

    protected function filename(): string
    {
        return 'Products_' . date('YmdHis');
    }
}
