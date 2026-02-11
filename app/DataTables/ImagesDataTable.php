<?php

namespace App\DataTables;

use App\Models\Image;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Http\Request;

class ImagesDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Image> $query Results from query() method.
     */
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
                        $q->where('image_name', 'LIKE', "%{$keyword}%")
                            ->orwhere('image_description', 'LIKE', "%{$keyword}%")
                            ->orwhere('image_price', 'LIKE', "%{$keyword}%")
                            ->orWhere('tags', 'LIKE', "%{$keyword}%")
                            ->orWhereHas('category', function ($catQuery) use ($keyword) {
                                $catQuery->where('category_name', 'LIKE', "%{$keyword}%");
                            });
                    });
                }
            })
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" class="row-checkbox" value="' . $row->id . '">';
            })
            ->addColumn('category_id', function ($row) {
                return $row->category->category_name;
            })
            ->addColumn('image', function ($row) {
                return '<img src="' . asset('uploads/images/low/' . $row->low_path) . '" 
                         class="preview-image" 
                         data-src="' . asset('uploads/images/high/' . $row->high_path) . '" 
                         width="80" height="80" style="cursor:pointer;" />';
            })
            ->addColumn('image_name', function ($row) {
                return $row->image_name;
            })
            ->addColumn('image_price', function ($row) {
                return $row->image_price;
            })
            ->addColumn('image_description', function ($row) {
                return $row->image_description;
            })
            ->addColumn('tags', function ($row) {
                return $row->tags;
            })
            ->addColumn('display_status', function ($row) {
                $checked = $row->is_display ? 'checked' : '';
                return '
                    <div class="form-check form-switch">
                        <input 
                            class="form-check-input toggle-display-images" 
                            type="checkbox" 
                            data-id="' . $row->id . '" 
                            ' . $checked . '
                        >
                    </div>
                ';
            })
            ->addColumn('created_at', function ($row) {
                return $row->created_at;
            })
            ->addColumn('actions', function ($row) {

                $cryptId = encrypt($row->id);
                $template_delete = decrypt($cryptId);

                $edit_url = route('admin.image_edit', $cryptId);
                $delete_url = route('admin.image_delete', $cryptId);

                return '<div class="action-icon" style="gap: 20px;display: flex">
                            <a class="" href="' .  $edit_url . '" title="Edit"><i class="ti ti-edit"></i></a>
                            <form id="delete_image_form' . $template_delete . '" action="' . $delete_url . '" method="POST">' .
                    csrf_field() .
                    '<button style="background:transparent;border:none;"     type="button" data-id="' . $template_delete . '" class="deleteButton-Icon delete_image"><i class="ti ti-trash"></i></button></form>
                            </div>';
            })

            ->rawColumns(['checkbox', 'name', 'image', 'image_name', 'image_price', 'image_description', 'tags', 'display_status', 'created_at', 'actions'])

        ;
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Image>
     */
    public function query(Image $model, Request $request): QueryBuilder
    {
        $columns = [
            0 => 'id',
            1 => 'category_id',
            2 => 'image',
            3 => 'created_at',
        ];

        $orderIndex = $request->input('order.0.column', 0);
        $column = $columns[$orderIndex] ?? 'id';


        $direction = 'desc';

        if (isset($request->order[0]['dir']) && $request->order[0]['dir'] == 'asc') {
            $direction = 'asc';
        }

        return Image::with('category')->orderBy($column, $direction);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('images-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(0)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('checkbox')
                ->title('<input type="checkbox" id="select-all">')
                ->orderable(false)
                ->searchable(false),
            Column::make('no')->title('No')->orderable(false),
            Column::make('category_id')->title('Catgeory')->orderable(true),
            Column::make('image')->title('Image')->orderable(false),
            Column::make('image_name')->title('Image')->orderable(false),
            Column::make('image_price')->title('Image Price ($)')->orderable(false),
            Column::make('image_description')->title('Image Description')->orderable(false),
            Column::make('tags')->title('Tags')->orderable(false),
            Column::make('display_status')->title('Display Status')->orderable(false),
            Column::make('created_at')->title('Created at')->orderable(true),
            Column::make('actions')->title('Actions')->orderable(false),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Images_' . date('YmdHis');
    }
}
