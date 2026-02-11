<?php

namespace App\DataTables;

use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Http\Request;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SubCategoryDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<SubCategory> $query Results from query() method.
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
                if ($this->request->has('search') && $this->request->get('search')['value']) {
                    $keyword = $this->request->get('search')['value'];
                    $query->where(function ($q) use ($keyword) {
                        $q->where('name', 'LIKE', "%{$keyword}%")
                            ->orWhere('created_at', 'LIKE', "%{$keyword}%")
                            ->orWhereHas('category', function ($catQuery) use ($keyword) {
                                $catQuery->where('category_name', 'LIKE', "%{$keyword}%");
                            });
                    });
                }
            })

            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" class="row-checkbox" value="' . $row->id . '">';
            })
            ->addColumn('category_name', function ($row) {
                return $row->category->category_name;
            })
            ->addColumn('subcategory_name', function ($row) {
                return $row->name;
            })
            ->addColumn('image', function ($row) {
                return '<img src="' . asset('uploads/images/sub_category/' . $row->image) . '" 
                         class="preview-image" 
                         data-src="' . asset('uploads/images/sub_category/' . $row->image) . '" 
                         width="80" height="80" style="cursor:pointer;" />';
            })
            ->addColumn('created_at', function ($row) {
                return $row->created_at;
            })
            ->addColumn('actions', function ($row) {

                $cryptId = encrypt($row->id);
                $template_delete = decrypt($cryptId);

                $edit_url = route('admin.sub_category_edit', $cryptId);
                $delete_url = route('admin.sub_category_delete', $cryptId);

                return '<div class="action-icon" style="gap: 20px;display: flex">
                            <a class="" href="' .  $edit_url . '" title="Edit"><i class="ti ti-edit"></i></a>
                            <form id="delete_sub_category_form' . $template_delete . '" action="' . $delete_url . '" method="POST">' .
                    csrf_field() .
                    '<button style="background:transparent;border:none;"     type="button" data-id="' . $template_delete . '" class="deleteButton-Icon delete_sub_category"><i class="ti ti-trash"></i></button></form>
                            </div>';
            })

            ->rawColumns(['checkbox', 'category_name', 'sub_category_name', 'image', 'created_at', 'actions']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<SubCategory>
     */
    public function query(SubCategory $model, Request $request): QueryBuilder
    {
        $columns = [
            0 => 'id',
            1 => 'category_id',
            2 => 'name',
            3 => 'created_at',
        ];

        $orderIndex = $request->input('order.0.column', 0);
        $column = $columns[$orderIndex] ?? 'id';


        $direction = 'desc';

        if (isset($request->order[0]['dir']) && $request->order[0]['dir'] == 'asc') {
            $direction = 'asc';
        }
        return SubCategory::with('category')->orderBy($column, $direction);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('subcategory-table')
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
            Column::make('category_name')->title('Category')->orderable(true),
            Column::make('subcategory_name')->title('Sub Category')->orderable(true),
            Column::make('image')->title('Image')->orderable(false),
            Column::make('created_at')->title('Created at')->orderable(true),
            Column::make('actions')->title('Actions')->orderable(false),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'SubCategory_' . date('YmdHis');
    }
}
