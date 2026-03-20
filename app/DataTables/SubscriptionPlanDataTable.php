<?php

namespace App\DataTables;

use App\Models\Subscription_plans;
use App\Models\SubscriptionPlan;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SubscriptionPlanDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<SubscriptionPlan> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" class="form-check-input row-checkbox" value="' . $row->id . '">';
            })
            ->addColumn('is_active', function ($row) {
                $checked = $row->is_active == '1' ? 'checked' : '';
                return '
        <div class="form-check form-switch">
            <input type="checkbox" 
                class="form-check-input toggle_is_active"
                data-id="' . encrypt($row->id) . '"
                ' . $checked . '>
        </div>';
            })
            ->addColumn('action', function ($row) {

                $updateButton = '
            <a href="' . route('admin.subscription_edit', ['id' => encrypt($row->id)]) . '"
               class="btn btn-primary btn-sm me-1 manage-customer-edit">
                <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_1776_416)">
                        <path d="M5.5415 5.5415H4.74984C4.32991 5.5415 3.92718 5.70832 3.63025 6.00525C3.33332 6.30218 3.1665 6.70491 3.1665 7.12484V14.2498C3.1665 14.6698 3.33332 15.0725 3.63025 15.3694C3.92718 15.6664 4.32991 15.8332 4.74984 15.8332H11.8748C12.2948 15.8332 12.6975 15.6664 12.9944 15.3694C13.2914 15.0725 13.4582 14.6698 13.4582 14.2498V13.4582" stroke="white" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M16.1381 5.21321C16.4499 4.90141 16.6251 4.47853 16.6251 4.03758C16.6251 3.59664 16.4499 3.17375 16.1381 2.86196C15.8263 2.55016 15.4034 2.375 14.9625 2.375C14.5216 2.375 14.0987 2.55016 13.7869 2.86196L7.125 9.50008V11.8751H9.5L16.1381 5.21321Z" stroke="white" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12.9546 4.31836L14.6819 6.04563" stroke="white" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
                    </g>
                </svg>
            </a>';

                $deleteButton = '
            <button type="button" class="btn btn-danger btn-sm deleteSubscriptionPlan"  data-id="' . encrypt($row->id) . '">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="M15.0316 7.66379L14.7861 15.0931C14.7652 15.7294 14.4972 16.3324 14.0389 16.7743C13.5807 17.2162 12.9682 17.4621 12.3316 17.4599H7.66797C7.03176 17.4622 6.41968 17.2166 5.96147 16.7752C5.50326 16.3338 5.23495 15.7314 5.21342 15.0955L4.96797 7.66379C4.9626 7.50104 5.0221 7.34283 5.13338 7.22395C5.24466 7.10507 5.39861 7.03527 5.56135 7.0299C5.7241 7.02453 5.88231 7.08403 6.00119 7.19531C6.12007 7.30659 6.18987 7.46054 6.19524 7.62329L6.44069 15.0544C6.45292 15.3717 6.58759 15.6718 6.81644 15.8919C7.04529 16.1119 7.3505 16.2347 7.66797 16.2344H12.3316C12.6495 16.2347 12.955 16.1115 13.184 15.891C13.4129 15.6704 13.5473 15.3696 13.5589 15.052L13.8043 7.62329C13.8097 7.46054 13.8795 7.30659 13.9984 7.19531C14.1173 7.08403 14.2755 7.02453 14.4382 7.0299C14.601 7.03527 14.7549 7.10507 14.8662 7.22395C14.9775 7.34283 15.037 7.50104 15.0316 7.66379ZM15.8434 5.19145C15.8434 5.35419 15.7788 5.51028 15.6637 5.62535C15.5486 5.74043 15.3926 5.80508 15.2298 5.80508H4.77037C4.60763 5.80508 4.45155 5.74043 4.33647 5.62535C4.22139 5.51028 4.15674 5.35419 4.15674 5.19145C4.15674 5.0287 4.22139 4.87262 4.33647 4.75754C4.45155 4.64246 4.60763 4.57781 4.77037 4.57781H6.67265C6.86708 4.57834 7.05475 4.5065 7.19914 4.37629C7.34352 4.24608 7.4343 4.06681 7.45381 3.87336C7.49909 3.41956 7.71169 2.99888 8.0502 2.69328C8.3887 2.38767 8.82885 2.21903 9.2849 2.22022H10.7147C11.1707 2.21903 11.6109 2.38767 11.9494 2.69328C12.2879 2.99888 12.5005 3.41956 12.5458 3.87336C12.5653 4.06681 12.656 4.24608 12.8004 4.37629C12.9448 4.5065 13.1325 4.57834 13.3269 4.57781H15.2292C15.3919 4.57781 15.548 4.64246 15.6631 4.75754C15.7782 4.87262 15.8428 5.0287 15.8428 5.19145H15.8434ZM8.51908 4.57781H11.4817C11.4011 4.39356 11.3483 4.19833 11.3252 3.99854C11.31 3.84728 11.2392 3.70705 11.1265 3.60502C11.0139 3.50299 10.8673 3.44642 10.7153 3.44627H9.28551C9.13349 3.44642 8.98694 3.50299 8.87425 3.60502C8.76156 3.70705 8.69076 3.84728 8.67556 3.99854C8.65226 4.19836 8.59993 4.3936 8.51908 4.57781ZM9.13701 13.875V8.6499C9.13701 8.48716 9.07236 8.33108 8.95728 8.216C8.8422 8.10092 8.68612 8.03627 8.52338 8.03627C8.36063 8.03627 8.20455 8.10092 8.08947 8.216C7.97439 8.33108 7.90974 8.48716 7.90974 8.6499V13.8775C7.90974 14.0402 7.97439 14.1963 8.08947 14.3114C8.20455 14.4265 8.36063 14.4911 8.52338 14.4911C8.68612 14.4911 8.8422 14.4265 8.95728 14.3114C9.07236 14.1963 9.13701 14.0402 9.13701 13.8775V13.875ZM12.0911 13.875V8.6499C12.0911 8.48716 12.0264 8.33108 11.9113 8.216C11.7962 8.10092 11.6402 8.03627 11.4774 8.03627C11.3147 8.03627 11.1586 8.10092 11.0435 8.216C10.9284 8.33108 10.8638 8.48716 10.8638 8.6499V13.8775C10.8638 14.0402 10.9284 14.1963 11.0435 14.3114C11.1586 14.4265 11.3147 14.4911 11.4774 14.4911C11.6402 14.4911 11.7962 14.4265 11.9113 14.3114C12.0264 14.1963 12.0911 14.0402 12.0911 13.8775V13.875Z" fill="white"/>
                </svg>
            </button>';

                return '<div class="d-flex">' . $updateButton . $deleteButton . '</div>';
            })
            ->rawColumns(['action', 'is_active', 'checkbox']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<SubscriptionPlan>
     */
    public function query(Subscription_plans $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('subscriptionplan-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                // Button::make('reset'),
                // Button::make('reload')
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
            Column::computed('DT_RowIndex')
                ->title('No')
                ->orderable(false)
                ->searchable(false),
            Column::make('name'),
            Column::make('duration_type'),
            Column::make('duration_value'),
            Column::make('total_clips'),
            Column::make('price_per_clip'),
            Column::make('discount_percentage'),
            Column::make('price'),
            Column::computed('is_active')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),

        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'SubscriptionPlan_' . date('YmdHis');
    }
}
