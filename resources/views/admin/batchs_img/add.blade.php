<div class="body-wrapper-inner">
    <!-- Modal Button -->
    {{-- @php
        dd(request()->submission_type);
    @endphp --}}
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">

                        <div class="diffrent-batches">

                            {{-- <p class="counting-show-batch">Show 1 to 10 of 26 Batches</p> --}}
                            <div class="flex-batch-filter-content">


                                <div class="diff-batches-content" id="batch-content-active">


                                    <div class="create-batch-head">
                                        <div class="create-batch-btn">
                                            <button type="button" class="btn btn-orange batch-create"
                                                data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                <i class="ti ti-plus"></i> Create Batch
                                            </button>



                                        </div>
                                        <div class="create-batch-filter">


                                            <button class="btn btn-orange search-desktop search-filter-openbtn"
                                                id="search_filter">
                                                <i class="fa-solid fa-magnifying-glass me-3"></i>
                                                Search and Filter</button>
                                            <button class="btn search-mobile search-filter-openbtn"
                                                id="search_filter_mobile">
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
                                                    <button class="btn  text-start dot-dropdown dropdown-toggle"
                                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fa-solid fa-ellipsis-vertical "></i>


                                                    </button>
                                                    <ul class="dropdown-menu more-detail-menu">
                                                        <li>
                                                            <button type="button" class="dropdown-item"
                                                                data-bs-toggle="modal" data-id="{{ $list['id'] }}"
                                                                data-name="{{ $list['title'] }}"
                                                                data-bs-target="#renameModal">
                                                                <i class="fa-solid fa-pencil me-3"></i>
                                                                Rename
                                                            </button>
                                                        </li>
                                                        <li> <button type="button" class="dropdown-item"
                                                                data-bs-toggle="modal" data-id="{{ $list['id'] }}"
                                                                data-bs-target="#deleteModal">
                                                                <i class="fa-solid fa-trash me-3"></i>
                                                                Delete
                                                            </button></li>
                                                        <li class="d-none"><a class="dropdown-item d-none"
                                                                href="#"><i
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
                                                        creative
                                                        video</label>
                                                @else
                                                    <label for=""> <i class="fa-solid fa-camera-retro"></i>
                                                        Gstock
                                                        creative
                                                        photo</label>
                                                @endif


                                            </div>
                                            <div class="batch-content-detail">
                                                <a class="batch-content-img"
                                                    href="{{ route('admin.add_new_img', encrypt($list['id'])) }}">


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
                                                            <img src="{{ asset('assets/front/img/no_img_avaliable.png') }}"
                                                                width="100%" height="100%" alt="">
                                                        @endif
                                                        @foreach ($files->take(4) as $index => $file)
                                                            @php
                                                                $url =
                                                                    $file['file_type'] == 'image'
                                                                        ? $file['low_path']
                                                                        : $file['thumbnail_path'];

                                                                // $url = asset($url);

                                                            @endphp


                                                            <div
                                                                class="item {{ $count == 3 && $index == 0 ? 'long-img' : '' }} {{ $count > 4 && $index == 3 ? 'overlay-parent' : '' }}">
                                                                <img src="{{ $url }}" width="100%"
                                                                    height="100%" alt="">


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




                                                    <tbody>
                                                        @foreach ($list['batch_files'] as $file)
                                                            <tr>
                                                                <td>
                                                                    <div class="img-id">
                                                                        <div class="table-img">
                                                                            {{-- <video class="w-100 h-100" muted>
                                                                                <source
                                                                                    src="{{ $file['file_path'] }}">
                                                                    </video> --}}
                                                                            @php
                                                                                $path = '';
                                                                                $path = $file['thumbnail_path'];
                                                                                if ($file['file_type'] == 'image') {
                                                                                    $path = $file['low_path'];
                                                                                }
                                                                            @endphp


                                                                            <img src="{{ $path }}"
                                                                                class="w-100 h-100"
                                                                                alt="Nature Flower">
                                                                        </div>
                                                                        <p>{{ $file['file_code'] }}</p>
                                                                    </div>
                                                                </td>


                                                                <td>{{ $file['original_name'] }}</td>


                                                                <td>{{ $file['title'] }}</td>


                                                                <td>
                                                                    <div class="create-count-div">
                                                                        <div class="circle-div circle-div1"></div>
                                                                        <p class="circel-count">
                                                                            {{-- {{ ucfirst($file['status']) }} --}}
                                                                            Accepted
                                                                        </p>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach


                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    @endforeach


                                    <div class="mt-4 navbar-section">
                                        {{ $batches->links() }}
                                    </div>




                                </div>
                                <form id="filterForm" action="" method="post">
                                    @csrf
                                    <div class="search-filter">
                                        <div class="search-filter-child-content" id="search-filter-content">
                                            <button type="button"
                                                class="search-filter-btn btn  btn-orange no-file-selected-title"
                                                id="close-filter">Search and Filter <i
                                                    class="fa-solid fa-angle-right"></i></button>
                                            <div class="filter-apply-text filter-text">
                                                <p>Applied Filters</p>
                                                <a href="#" class="reset-filter">Reset</a>
                                            </div>
                                            <div class="filter-search-text">
                                                <div class="input-search-filter flex-nowrap">
                                                    <i class="fa-solid fa-magnifying-glass"></i>
                                                    <input type="text" name="search"
                                                        value="{{ request()->search ?? '' }}"
                                                        placeholder="Enter Search Text"
                                                        aria-describedby="addon-wrapping">
                                                </div>
                                            </div>
                                            <div class="filter-text submission-type-filter">
                                                <p>Submission type</p>
                                                <ul>
                                                    {{-- <li>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="" id="checkDefault1">
                                                        <label class="form-check-label" for="checkDefault1">
                                                            Gstock Creative illustration
                                                        </label>
                                                    </div>
                                                </li> --}}


                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="checkDefault2" name="submission_type[]"
                                                                value="image"
                                                                {{ in_array('image', request()->submission_type ?? []) ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="checkDefault2">
                                                                Gstock Creative Image
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="checkDefault3" name="submission_type[]"
                                                                value="video"
                                                                {{ in_array('video', request()->submission_type ?? []) ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="checkDefault3">
                                                                Gstock Creative Video
                                                            </label>
                                                        </div>
                                                    </li>
                                                    {{-- <li>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="" id="checkDefault4">
                                                        <label class="form-check-label" for="checkDefault4">
                                                            Gstock editional Image
                                                        </label>
                                                    </div>
                                                </li> --}}
                                                </ul>
                                            </div>
                                            <div class="batches-status filter-text">
                                                <p>Batch Status</p>
                                                <ul>
                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="1" name="status[]" id="checkDefault5"
                                                                {{ in_array('1', request()->status ?? []) ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="checkDefault5">
                                                                Active
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="0" name="status[]" id="checkDefault6"
                                                                {{ in_array('0', request()->status ?? []) ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="checkDefault6">
                                                                Close <i class="fa-regular fa-circle-question"></i>
                                                            </label>
                                                        </div>
                                                    </li>
                                                    {{-- <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="" id="checkDefault7">
                                                            <label class="form-check-label" for="checkDefault7">
                                                                Needs revesion
                                                            </label>
                                                        </div>
                                                    </li> --}}


                                                </ul>
                                            </div>
                                            <div class="date-range-filter filter-text">
                                                <p>Date range</p>
                                                <div class="date-range">


                                                    <div class="date-inputs">
                                                        <div class="date-box">
                                                            <span class="date-title">Start date *</span>
                                                            <input type="date" name="start_date"
                                                                {{ request()->start_date ? 'value=' . request()->start_date : '' }}>
                                                            <span class="date-format">MM/DD/YYYY</span>
                                                        </div>


                                                        <span class="date-separator">to</span>


                                                        <div class="date-box">
                                                            <span class="date-title">End date *</span>
                                                            <input type="date" name="end_date"
                                                                {{ request()->end_date ? 'value=' . request()->end_date : '' }}>
                                                            <span class="date-format">MM/DD/YYYY</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="sort-by-filter filter-text">
                                                <p>Sort by</p>
                                                {{-- <button class="btn w-100 text-start  batch-dropdown dropdown-toggle"
                                                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Dropdown<i class="fa-solid fa-angle-down"></i>
                                                </button>
                                                <ul class="dropdown-menu batch-filter-dropdown-menu">
                                                    <li><a class="dropdown-item" href="#">Action</a></li>
                                                    <li><a class="dropdown-item" href="#">Another action</a>
                                                    </li>
                                                    <li><a class="dropdown-item" href="#">Something else
                                                            here</a>
                                                    </li>
                                                </ul> --}}
                                                <select class="form-select mr-sm-2 batch-inp" name="select_field"
                                                    id="select_field">
                                                    <option value="id">Id</option>
                                                    <option value="title">
                                                        Batch Name</option>
                                                    <option value="created_at">
                                                        Created At</option>
                                                </select>
                                            </div>
                                            <div class="direction-filter filter-text">
                                                <p>Direction</p>


                                                <ul>
                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="direction" value="asc" id="radiodefault1">
                                                            <label class="form-check-label" for="radiodefault1">
                                                                Ascending
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="direction" value="desc" id="radiodefault2"
                                                                checked>
                                                            <label class="form-check-label" for="radiodefault2">
                                                                Descending
                                                            </label>
                                                        </div>
                                                    </li>




                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>




                    </div>


                </div>








            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="renameModal" tabindex="-1" aria-labelledby="renameModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="">
                <div class="modal-header">
                    <h5 class="modal-title" id="renameModalLabel">Rename Batch


                    </h5>
                </div>
                <input type="hidden" name="batch_id" id="rename_batch_id">


                <div class="modal-body">
                    <label class="modal-label">Batch Name
                    </label>
                    <input type="text" name="branch_name" id="rename_batch_name" class="form-control batch-inp"
                        placeholder="Enter new name">
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-all-dark btn-hover-dark" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="button" class="btn btn-orange edit_branch_name">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="renameModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered text-center">
        <div class="modal-content">
            <div class="modal-header text-center m-auto ">
                <h5 class="modal-title" id="renameModalLabel">Delete Confirmation</h5>
            </div>
            <input type="hidden" name="batch_id" id="delete_batch_id">


            <div class="modal-body text-center">
                <div class="delete-icon  m-auto"><i class="fa-solid fa-triangle-exclamation "></i></div>
                <p style="font-size: 16px; color:gray; margin-top:15px;">If you delete the link will be gone forever.
                    Are you sure you want to procced</p>
            </div>


            <div class="modal-footer text-center m-auto">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                    Cancel
                </button>
                <button type="button" class="btn btn-danger delete_branch" style="background-color: red;">
                    Delete
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade " id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-box">


        <div class="modal-content">
            <form id="create_batch" class="auth-form" method="POST" action="{{ route('admin.storeBatch') }}">
                @csrf
                <div class="modal-header">
                    <h2 class="modal-title" id="exampleModalLabel">Create Batch</h2>
                </div>
                <div class="modal-body batch-create-modal">
                    {{-- <div class="dropdown">
                                                        <input type="hidden" name="submission_type"
                                                            id="submission_type">


                                                        <label for="" class="modal-label">Submission
                                                            type</label>
                                                        <button
                                                            class="btn w-100 text-start  batch-dropdown dropdown-toggle"
                                                            type="button" data-bs-toggle="dropdown"
                                                            aria-expanded="false">
                                                            Select Type<i class="fa-solid fa-angle-down"></i>
                                                        </button>
                                                        <ul class="dropdown-menu batch-dropdown-menu">
                                                            <li><a class="dropdown-item" href="#"
                                                                    data-value="image">Image</a></li>
                                                            <li><a class="dropdown-item" href="#"
                                                                    data-value="video">Video</a>
                                                            </li>
                                                            <li><a class="dropdown-item"
                                                                    href="#"data-value="artwork">Art Work</a></li>
                                                        </ul>
                                                    </div> --}}
                    <div class="modal-code">
                        <label for="category" class=" modal-label">Submission
                            Type</label>
                        <select class="form-select mr-sm-2 batch-inp" name="submission_type" id="category">
                            <option value="">Choose Submission Type...</option>
                            <option value="image">
                                Image</option>
                            <option value="video">
                                Video</option>
                        </select>


                    </div>
                    {{-- <div class="modal-code">
                                                        <label for="" class="modal-label">Brief Code</label>
                                                        <div class="input-group ">
                                                            <input type="text" class="form-control batch-inp"
                                                                placeholder="Breif code (optional)" id="brief_code"
                                                                name="brief_code" aria-describedby="addon-wrapping"
                                                                oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                                        </div>
                                                    </div> --}}
                    <div class="modal-name">
                        <label for="" class="modal-label">Batch Name</label>
                        <div class="input-group ">
                            <input type="text" class="form-control batch-inp" placeholder="Batch Name"
                                name="batch_name" aria-describedby="addon-wrapping">
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-all-dark btn-hover-dark btn"
                        data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class=" btn btn-orange">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>
