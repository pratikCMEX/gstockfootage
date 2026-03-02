<?php

namespace App\DataTables;

use App\Models\WalletTransactions;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Http\Request;

class TransactionsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Transaction> $query Results from query() method.
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
            ->addColumn('transaction_type', function ($row) {
                return $row->transaction_type;
            })
            ->addColumn('amount', function ($row) {
                return $row->amount;
            })
            ->addColumn('balance_before', function ($row) {
                return $row->balance_before;
            })
            ->addColumn('balance_after', function ($row) {
                return $row->balance_after;
            })
            // ->addColumn('reference_id', function ($row) {
            //     return $row->reference_id;
            // })
            ->addColumn('reference_id', function ($row) {
                return '
                    <span class="ref-text">' . e($row->reference_id) . '</span>
                    <i class="ti ti-clipboard-copy copy-ref"
                       style="cursor:pointer; margin-left:6px;"
                       data-ref="' . e($row->reference_id) . '"
                       title="Copy"></i>
                ';
            })
            ->addColumn('status', function ($row) {
                return $row->status;
            })

            ->addColumn('transaction_date', function ($row) {
                return $row->created_at;
            })
            ->addColumn('actions', function ($row) {

                $cryptId = encrypt($row->id);
                $template_delete = decrypt($cryptId);

                // $edit_url = route('admin.image_edit', $cryptId);
                $delete_url = route('admin.transaction_delete', $cryptId);

                return '<div class="action-icon" style="gap: 20px;display: flex">
                            <form id="delete_transaction_form' . $template_delete . '" action="' . $delete_url . '" method="POST">' .
                    csrf_field() .
                    '<button style="background:transparent;border:none;"     type="button" data-id="' . $template_delete . '" class="deleteButton-Icon delete_transaction"><i class="ti ti-trash"></i></button></form>
                            </div>';
            })

            ->rawColumns(['checkbox', 'email', 'transaction_type', 'amount', 'balance_before', 'balance_after', 'reference_id', 'status', 'transaction_date', 'actions']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Transaction>
     */
    public function query(WalletTransactions $model, Request $request): QueryBuilder
    {
        $columns = [
            0 => 'id',
            1 => 'user_id',
            2 => 'transaction_type',
            3 => 'amount',
            4 => 'balance_before',
            5 => 'balance_after',
            6 => 'reference_id',
            7 => 'description',
            8 => 'status',
        ];

        $orderIndex = $request->input('order.0.column', 0);
        $column = $columns[$orderIndex] ?? 'id';


        $direction = 'desc';

        if (isset($request->order[0]['dir']) && $request->order[0]['dir'] == 'asc') {
            $direction = 'asc';
        }

        return WalletTransactions::with('user')->orderBy($column, $direction);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('transactions-table')
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
                ->title('<input type="checkbox" class="form-check-input" id="select-all">')
                ->orderable(false)
                ->searchable(false),
            Column::make('no')->title('No')->orderable(false),
            Column::make('email')->title('Email')->orderable(true),
            Column::make('transaction_type')->title('Type')->orderable(false),
            Column::make('amount')->title('Amount')->orderable(false),
            Column::make('balance_before')->title('Balance Before ($)')->orderable(false),
            Column::make('balance_after')->title('Balance After ($)')->orderable(false),
            Column::make('reference_id')->title('Reference id')->orderable(false),
            Column::make('status')->title('Status')->orderable(false),
            Column::make('transaction_date')->title('Transaction Date')->orderable(true),
            Column::make('actions')->title('Actions')->orderable(false),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Transactions_' . date('YmdHis');
    }
}
