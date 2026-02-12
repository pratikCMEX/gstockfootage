<?php

namespace App\DataTables;

use App\Models\Video;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Http\Request;

class VideosDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Video> $query Results from query() method.
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
                        $q->where('video_name', 'LIKE', "%{$keyword}%")
                            ->orwhere('video_description', 'LIKE', "%{$keyword}%")
                            ->orwhere('video_price', 'LIKE', "%{$keyword}%")
                            ->orwhere('tags', 'LIKE', "%{$keyword}%")
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
                return $row->category->category_name ?? '';
            })
            ->addColumn('subcategory_id', function ($row) {
                return $row->subcategory->name ?? '';
            })
            ->addColumn('collection_id', function ($row) {
                return $row->collections->name ?? '';
            })
            ->addColumn('video', function ($row) {
                $thumbnail = asset('uploads/videos/thumbnails/' . $row->thumbnail_path);
                if ($row->thumbnail_path == "") {
                    $thumbnail = asset('assets/admin/images/demo_thumbnail.png');
                }
                $videoUrl = asset('uploads/videos/high/' . $row->high_path);
                // $videoUrl = route('admin.video_stream', $row->high_path);
                // $videoUrl = route('admin.video_stream', ['file' => "high/$row->high_path"]);
                // $videoUrl = route('admin.video_stream', ['file' => "high/$row->high_path"]);



                return '<div class="video-thumbnail-wrapper position-relative d-inline-block">  
                            <img src="' . $thumbnail . '" 
                            width="100" height="100" 
                            class="video-thumbnail rounded cursor-pointer" 
                            data-video="' . $videoUrl . '" 
                            alt="Video Thumbnail">
                              <i class="ti ti-player-play play-icon video-thumbnail" data-video="' . $videoUrl . '" ></i>
                        </div>';
            })
            ->addColumn('video_name', function ($row) {
                return $row->video_name;
            })
            ->addColumn('video_price', function ($row) {
                return $row->video_price;
            })
            ->addColumn('video_description', function ($row) {
                return $row->video_description;
            })
            ->addColumn('tags', function ($row) {
                return $row->tags;
            })
            ->addColumn('display_status', function ($row) {
                $checked = $row->is_display ? 'checked' : '';
                return '
                    <div class="form-check form-switch">
                        <input 
                            class="form-check-input toggle-display-videos" 
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

                $edit_url = route('admin.video_edit', $cryptId);
                $delete_url = route('admin.video_delete', $cryptId);

                return '<div class="action-icon" style="gap: 20px;display: flex">
                            <a class="" href="' .  $edit_url . '" title="Edit"><i class="ti ti-edit"></i></a>
                            <form id="delete_video_form' . $template_delete . '" action="' . $delete_url . '" method="POST">' .
                    csrf_field() .
                    '<button style="background:transparent;border:none;"     type="button" data-id="' . $template_delete . '" class="deleteButton-Icon delete_video"><i class="ti ti-trash"></i></button></form>
                            </div>';
            })

            ->rawColumns(['checkbox', 'name', 'video', 'video_name', 'video_price', 'video_description', 'display_status', 'created_at', 'actions'])

        ;
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Video>
     */
    public function query(Video $model, Request $request): QueryBuilder
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

        return Video::with(['category', 'subCategory', 'collections'])->orderBy($column, $direction);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('videos-table')
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
            Column::make('subcategory_id')->title('Sub Catgeory')->orderable(true),
            Column::make('collection_id')->title('Collection')->orderable(true),
            Column::make('video')->title('Video')->orderable(false),
            Column::make('video_name')->title('Video Name')->orderable(false),
            Column::make('video_price')->title('Video Price ($)')->orderable(false),
            Column::make('video_description')->title('Video Description')->orderable(false),
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
        return 'Videos_' . date('YmdHis');
    }
}
