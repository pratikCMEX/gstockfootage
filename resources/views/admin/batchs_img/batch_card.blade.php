<div class="diff-batches-content" id="batch-content-active">
    <div class="create-batch-head">
        <div class="create-batch-btn">
            <button type="button" class="btn btn-orange batch-create" data-bs-toggle="modal"
                data-bs-target="#exampleModal">
                <i class="ti ti-plus"></i> Create Batch
            </button>



        </div>
        <div class="create-batch-filter">


            <button class="btn btn-orange search-desktop search-filter-openbtn" id="search_filter">
                <i class="fa-solid fa-magnifying-glass me-3"></i>
                Search and Filter</button>
            <button class="btn search-mobile search-filter-openbtn" id="search_filter_mobile">
                <i class="fa-solid fa-magnifying-glass me-3"></i></button>


        </div>
    </div>
    @if (count($batches) == 0)
        <p class="counting-show-batch"> No Available Batches
        </p>
    @else
        <p class="counting-show-batch"> Show {{ $batches->firstItem() }} to
            {{ $batches->lastItem() }} of {{ $batches->total() }} Batches
        </p>
    @endif
    {{-- {{ dd($batch_list) }} --}}
    @foreach ($batch_list as $list)
        <div class="batch-content">
            <div class="batch-content-title">
                <h5>{{ $list['title'] }}</h5>
                <div class="content-dropdown">
                    <button class="btn  text-start dot-dropdown dropdown-toggle" type="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-ellipsis-vertical "></i>


                    </button>
                    <ul class="dropdown-menu more-detail-menu">
                        <li>
                            <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                data-id="{{ $list['id'] }}" data-name="{{ $list['title'] }}"
                                data-bs-target="#renameModal">
                                <i class="fa-solid fa-pencil me-3"></i>
                                Rename
                            </button>
                        </li>
                        <li> <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                data-id="{{ $list['id'] }}" data-bs-target="#deleteModal">
                                <i class="fa-solid fa-trash me-3"></i>
                                Delete
                            </button></li>
                        <li class="d-none"><a class="dropdown-item d-none" href="#"><i
                                    class="fa-solid fa-arrow-up-right-from-square me-3"></i>
                                See Published</a></li>
                    </ul>
                </div>
            </div>
            <div class="batches-label">
                {{-- <label for=""> <i class="fa-solid fa-video"></i> Gstock creative
                    video</label> --}}
                @if ($list['submission_type'] == 'video')
                    <label for=""> <i class="fa-solid fa-video"></i> Gstock
                        Creative
                        Video</label>
                @else
                    <label for=""> <i class="fa-solid fa-camera-retro"></i>
                        Gstock
                        Creative
                        Photo</label>
                @endif


            </div>
            <div class="batch-content-detail">
                <a class="batch-content-img" href="{{ route('admin.add_new_img', encrypt($list['id'])) }}">


                    @php
                        $files = $list['batch_files'];
                        $count = count($files);

                        if ($count == 1) {
                            $class = '';
                        } elseif ($count == 2) {
                            $class = 'image-2';
                        } elseif ($count == 3) {
                            $class = 'image-3';
                        } elseif ($count == 4) {
                            $class = 'image-4';
                        } elseif ($count > 4) {
                            $class = 'image-more';
                        } else {
                            $class = '';
                        }
                        // dd($files->take(4));
                    @endphp


                    <div class="batch-collect-imgs {{ $class }}">


                        @if (count($files) == 0)
                            <img src="{{ asset('assets/front/img/no_img_avaliable.png') }}" width="100%"
                                height="100%" alt="">
                        @endif
                        @foreach ($files->take(4) as $index => $file)
                            @php
                                $url =
                                    $file['file_type'] == 'image'
                                        ? ($file['mid_path'] != ''
                                            ? $file['mid_path']
                                            : $file['file_path'])
                                        : $file['thumbnail_path'] ?? asset('assets/admin/images/demo_thumbnail.png');
                                // $url = asset($url);
                            @endphp


                            <div
                                class="item {{ $count == 3 && $index == 0 ? 'long-img' : '' }} {{ $count > 4 && $index == 3 ? 'overlay-parent' : '' }}">
                                <img src="{{ $url }}" width="100%" height="100%" alt="">


                                @if ($count > 4 && $index == 3)
                                    <div class="img-overlay">+{{ $count - 4 }}
                                    </div>
                                @endif
                            </div>
                        @endforeach


                    </div>
                </a>
                <div class="batch-content-create">
                    <div class="batch-content-create-text">
                        <p class="batchid">BatchID {{ $list['batch_code'] }}</p>
                        {{-- <p class="batchcreated">Created : Feb 16,2026</p> --}}
                        <div>
                            <p class="batchcreated">
                                Created :
                                {{ \Carbon\Carbon::parse($list['created_at'])->format('M d, Y') }}
                            </p>
                            <span>Last Updated
                                :{{ \Carbon\Carbon::parse($list['updated_at'])->format('M d, Y') }}
                            </span>
                        </div>


                    </div>
                    <!-- <div class="batch-content-create-counts">
                        <div class="create-count-div">
                            <div class="circle-div circle-div1"></div>
                            <p class="circel-count"><span>0</span> Accepted</p>
                        </div>
                        <div class="create-count-div">
                            <div class="circle-div circle-div2"></div>
                            <p class="circel-count"><span>0</span> Rejected</p>
                        </div>
                        <div class="create-count-div">
                            <div class="circle-div circle-div3"></div>
                            <p class="circel-count"><span>0</span> Need Revesion</p>
                        </div>
                        <div class="create-count-div">
                            <div class="circle-div circle-div4"></div>
                            <p class="circel-count"><span>0</span> In Interview</p>
                        </div>
                        <div class="create-count-div">
                            <div class="circle-div circle-div5"></div>
                            <p class="circel-count"><span>0</span> Not Submitted</p>
                        </div>
                    </div> -->
                </div>
                <div class="more-detail">
                    <button class="btn more-detail-btn " type="button">
                        <i class="fa-solid fa-angle-down"></i>More Detail
                    </button>


                </div>
            </div>
            <div class="batch-content-table-details">
                <table>
                    <thead>
                        <th>
                            <tr>
                                <td class="table-heading">File ID</td>
                                <td class="table-heading">File Name</td>
                                <td class="table-heading">Title</td>
                                <td class="table-heading">Status</td>
                            </tr>
                        </th>
                    </thead>




                    <tbody class="batch-files-tbody">
                    </tbody>
                    <div class="load-more-wrap text-center mt-3" style="display:none;">
                        <button class="btn btn-orange load-more-btn" data-batch-id="{{ $list['id'] }}" data-page="1"
                            data-last-page="1">
                            Load More
                        </button>
                    </div>
                    <div class="batch-files-loader text-center mt-2" style="display:none;">
                        <span>Loading...</span>
                    </div>
                </table>
            </div>
        </div>
    @endforeach


    <div class="mt-4 navbar-section">
        {{ $batches->links() }}
    </div>




</div>
