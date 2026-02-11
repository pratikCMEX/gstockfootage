<?php

namespace App\DataTables;

use App\Models\UserPlan;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Http\Request;


class UserPlanDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<UserPlan> $query Results from query() method.
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
                    // $query->where(function ($q) use ($keyword) {
                    //     $q->where('image_name', 'LIKE', "%{$keyword}%")
                    //         ->orwhere('image_description', 'LIKE', "%{$keyword}%")
                    //         ->orWhereHas('user', function ($catQuery) use ($keyword) {
                    //             $catQuery->where('email', 'LIKE', "%{$keyword}%");
                    //         });
                    // });
                }
            })
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" class="row-checkbox" value="' . $row->id . '">';
            })
            ->addColumn('email', function ($row) {
                return $row->user->email;
            })
            ->addColumn('plan', function ($row) {
                return $row->plan_id;
            })
            ->addColumn('start_date', function ($row) {
                return $row->start_date;
            })
            ->addColumn('end_date', function ($row) {
                return $row->end_date;
            })
            ->addColumn('status', function ($row) {
                return $row->status;
            })
            ->addColumn('purchase_date', function ($row) {
                return $row->created_at;
            })
            ->addColumn('actions', function ($row) {

                $cryptId = encrypt($row->id);
                $template_delete = decrypt($cryptId);

                // $edit_url = route('admin.image_edit', $cryptId);
                $delete_url = route('admin.userplan_delete', $cryptId);

                return '<div class="action-icon" style="gap: 20px;display: flex">
                        <form id="delete_userplan_form' . $template_delete . '" action="' . $delete_url . '" method="POST">' .
                    csrf_field() .
                    '<button style="background:transparent;border:none;"     type="button" data-id="' . $template_delete . '" class="deleteButton-Icon delete_userplan"><i class="ti ti-trash"></i></button></form>
                        </div>';
            })

            ->rawColumns(['checkbox', 'email', 'plan', 'start_date', 'end_date', 'status', 'purchase_date', 'actions']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<UserPlan>
     */
    public function query(UserPlan $model, Request $request): QueryBuilder
    {
        $columns = [
            0 => 'id',
            1 => 'user_id',
            2 => 'plan_id',
            3 => 'start_date',
            4 => 'end_date',
            5 => 'status',
        ];

        $orderIndex = $request->input('order.0.column', 0);
        $column = $columns[$orderIndex] ?? 'id';


        $direction = 'desc';

        if (isset($request->order[0]['dir']) && $request->order[0]['dir'] == 'asc') {
            $direction = 'asc';
        }

        return UserPlan::with('user')->orderBy($column, $direction);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('userplan-table')
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
            Column::make('email')->title('Email')->orderable(true),
            Column::make('start_date')->title('Start Date')->orderable(false),
            Column::make('end_date')->title('End Date')->orderable(false),
            Column::make('status')->title('Status')->orderable(false),
            Column::make('purchase_date')->title('Purchase Date')->orderable(false),
            Column::make('actions')->title('Actions')->orderable(false),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'UserPlan_' . date('YmdHis');
    }
}
