{{-- {{ dd($batch_data) }} --}}
@php
    $category = getCategory();
    $getCollections = getCollections();
@endphp
<div class="body-wrapper-inner upload-main">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="card_header">
                    <button class="back-btn" onclick="history.back()">
                        <i class="fa-solid fa-arrow-left"></i>
                    </button>
                    <div class="header-title-section">
                        <h3 class="batch_name">{{ $batch->title }}</h3>
                        <div class="batches-label">
                            @if ($batch->submission_type == 'image')
                                <label for="">
                                    <i class="fa-solid fa-camera-retro"></i> Gstock creative
                                    image</label>
                            @else
                                <label for="">
                                    <i class="fa-solid fa-video"></i> Gstock
                                    creative
                                    video</label>
                            @endif
                        </div>
                    </div>
                    <div class="dot-menu text-end">
                        <button class="btn  text-start dot-dropdown dropdown-toggle" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-ellipsis-vertical "></i></button>
                        <ul class="dropdown-menu more-detail-menu">
                            <li>
                                <button type="button" class="dropdown-item-upload dropdown-item BatchrenameModal"
                                    data-bs-toggle="modal" data-bs-target="#BatchrenameModal"
                                    data-id="{{ $batch->id }}" data-name="{{ $batch->title }}">
                                    <i class="fa-solid fa-pencil"></i>
                                    Rename
                                </button>
                            </li>
                            {{-- <li> <button type="button" class="dropdown-item-upload dropdown-item"
                                    data-bs-toggle="modal" data-bs-target="#BatchNotModal">
                                    <i class="fa-regular fa-file"></i>
                                    Add or edit note for inspectors
                                </button></li> --}}

                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 ">
                        <div class="">
                            <div class="create-upload-head">
                                <div class="select-img">
                                    <div class="show-select">
                                        <button class="btn" type="button">

                                            <i class="fa-solid fa-xmark  close-select-btn" style="color: white;"></i>
                                        </button>
                                        <button type="button" class="btn btn-light">Show selected</button>
                                    </div>
                                    <div class="delete-submit">
                                        <button type="button" style="display: flex; align-items: center"
                                            class="btn btn-light delete-btn-batch">Delete <span class="delete-count"
                                                style="margin-left: 10px; display:flex; align-items:center; justify-content:center; height:20px; width:100%; min-width:20px;  padding: 4px; font-size: 12px; background-color: black; color: white; border-radius: 20px;">
                                                34</span></button>
                                        {{-- <button type="button" class="btn select-submit-btn"><i
                                                class="fa-solid fa-paper-plane"></i> Submit <span>0</span></button> --}}
                                    </div>
                                </div>
                                <div class="two-btns">
                                    <button type="button" class="upload-btn btn btn-orange batch-create"><i
                                            class="ti ti-plus"></i> Upload</button>
                                    <div class="upload-from-device">
                                        <div class="upload-main-content">
                                            <div class="upload-from-device-head">
                                                <button type="button" class="btn upload-close-btn"><i
                                                        class="fa-solid fa-xmark"></i> Upload</button>
                                                <div class="batches-label">

                                                    @if ($batch->submission_type == 'image')
                                                        <label for="">
                                                            <i class="fa-solid fa-camera-retro"></i> Gstock creative
                                                            image</label>
                                                    @else
                                                        <label for="">
                                                            <i class="fa-solid fa-video"></i> Gstock
                                                            creative
                                                            video</label>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="upload-from-device-content
                                                text-center align-items-center"
                                                id="dndZone" data-type="{{ $batch->submission_type }}">
                                                <div class="upload-device-content-detail">
                                                    <h2 class="upload-title">
                                                        Drag and drop your files here or upload from <span
                                                            class="upload-span">
                                                            Dropbox
                                                        </span><i class="fa-regular fa-circle-question"></i></h2>
                                                    {{-- <label for="myfile"
                                                        class="btn btn-orange btn-upload-device">Upload from
                                                        device</label> --}}
                                                    <label for="myfile" class="btn btn-orange btn-upload">Select
                                                        file</label>
                                                    <button for="111myfile" disabled
                                                        class="btn btn-orange btn-upload-device"
                                                        data-type={{ $batch->submission_type }}>Upload Files</button>
                                                    {{-- <input type="file" id="myfile" name="myfile" multiple hidden> --}}

                                                    @php
                                                        $batch_type = '';
                                                        if ($batch->submission_type == 'video') {
                                                            $batch_type = 'video';
                                                        } else {
                                                            $batch_type = 'image';
                                                        }
                                                    @endphp
                                                    <input type="file" name="files[]" hidden id="myfile" multiple
                                                        accept="{{ $batch_type == 'video' ? 'video/*,.zip' : 'image/*,.zip' }}"
                                                        required>

                                                    <!-- <div class="apply-default-template">
                                                        <div class="form-check form-switch ps-0 upload-check">
                                                            <input class="form-check-input m-0" type="checkbox"
                                                                role="switch" id="flexSwitchCheckDefaultupload">
                                                            <label class="form-check-label  ps-3"
                                                                style="cursor: pointer;"
                                                                for="flexSwitchCheckDefaultupload">Apply Default
                                                                Template input</label>
                                                        </div>
                                                    </div> -->
                                                </div>
                                                <div class="">

                                                    <div class="upload-device-list-detail text-start">
                                                        <ul>
                                                            <li>Accepted Video file types:mov.mp4 or mxf</li>
                                                            <li>Maximum file size : 6GB</li>
                                                            <li>Supported browsers : Chrome , firefox ,IE10+ , safari 6+
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="upload-preview-strip" id="previewStrip">
                                                        <div class="preview-strip-label">
                                                            <span id="previewLabel">0 files selected</span>
                                                            <span class="clear-link" id="clearAll">Clear all</span>
                                                        </div>
                                                        <div class="preview-thumbs" id="previewThumbs"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-all-dark btn-hover-dark select-btn">Select
                                        All</button>
                                </div>
                                <div class="search-filter d-none">
                                    <button class="btn btn-orange search-filter-openbtn upload-desk-searchfilter"
                                        id="upload_search_filter">
                                        <i class="fa-solid fa-magnifying-glass me-3"></i>
                                        Search and Filter</button>
                                    <button class="btn btn-primary upload-mobile-searchfilter search-filter-openbtn"
                                        id="upload_search_filter_mobile">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="img-responsive-head">
                                <div class="image-range">
                                    <i class="fa-solid fa-image small-img"></i>
                                    <div class="range-container">
                                        <input type="range" min="1" max="5" value="1"
                                            id="rangeSlider" class="slider">
                                    </div>
                                    <i class="fa-solid fa-image big-img"></i>
                                </div>
                                {{-- <p>34 items</p> --}}
                                <p class="total-files-count">{{ count($batch_data) }} Items</p>
                            </div>
                            {{-- @if (count($batch_data) == 0) --}}
                            <div class="empty data-empty {{ count($batch_data) == 0 ? '' : 'd-none' }}"
                                style="border: 1px dashed var(--secendory); border-radius: 10px; height: calc(100dvh - 255px); margin: auto ; text-align: center; display: flex; justify-content: center; align-items: center; ">
                                <p
                                    style="margin: auto; font-size: 25px; color:var(--secendory); font-family:var(--font-inter-medium)">
                                    No Data Found
                                </p>
                            </div>
                            {{-- @endif --}}
                            <div class="images-content images-content-5">
                                <input type="hidden" id="batch_id" value="{{ $batch->id }}">

                                @foreach ($batch_data as $data)
                                    <div class="upload-image" id="upload_images" data-id="{{ $data->id }}">
                                        <div class="dot-menu text-end align-self-end">
                                            <button class="btn  text-start dot-dropdown dropdown-toggle"
                                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa-solid fa-ellipsis-vertical "></i></button>
                                            <ul class="dropdown-menu more-detail-menu">
                                                <li>
                                                    <button class=" batch_file_keyword"
                                                        data-keywords="{{ $data->keywords }}">
                                                        <i class="fa-regular fa-clipboard me-3"></i>
                                                        Copy Keyword
                                                    </button>
                                                </li>
                                                {{-- <li> <button type="button" class="dropdown-item-upload dropdown-item"
                                                        data-bs-toggle="modal" data-bs-target="#setthumbnail">
                                                        <i class="fa-solid fa-pencil me-3"></i>
                                                        SET NEW THUMBNAIL FRAME
                                                    </button></li> --}}

                                            </ul>
                                        </div>
                                        <div class="image-upload">
                                            {{-- @if ($data['file_type'] == 'image')
                                                <img src="{{ asset('uploads/batch/images/low') . '/' . $data['low_path'] }}"
                                                    alt="">
                                            @else
                                                @if ($data['thumbnail_path'] == null)
                                                    <img
                                                        src="{{ asset('assets/admin/images/demo_thumbnail.png') }}" />
                                                @else
                                                    <img src="{{ asset('uploads/batch/videos/thumbnails') . '/' . $data['thumbnail_path'] }}"
                                                        alt="">
                                                @endif
                                            @endif --}}
                                            @if ($data['file_type'] == 'image')
                                                <img src="{{ Storage::disk('s3')->url(ltrim($data['low_path'], '/')) }}"
                                                    alt="">
                                            @else
                                                @if ($data['thumbnail_path'] == null)
                                                    <img
                                                        src="{{ asset('assets/admin/images/demo_thumbnail.png') }}" />
                                                @else
                                                    <img src="{{ Storage::disk('s3')->url(ltrim($data['thumbnail_path'], '/')) }}"
                                                        alt="">
                                                @endif
                                            @endif
                                        </div>
                                        <div class="image-title-id">
                                            {{-- <div class="error"><i class="fa-solid fa-ban"></i></div> --}}
                                            <div class="check"><i class="fa-solid fa-circle-check"></i></div>
                                            <div class="upload-title-img">
                                                <div class="img-title">{{ $data['original_name'] }} </div>
                                                <div class="img-id">ID: 23870945</div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                {{-- <div class="upload-image" id="upload_images">
                                    <div class="dot-menu text-end align-self-end">
                                        <button class="btn  text-start dot-dropdown dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-ellipsis-vertical "></i></button>
                                        <ul class="dropdown-menu more-detail-menu">
                                            <li>
                                                <button type="button" class="dropdown-item-upload dropdown-item"
                                                    data-bs-toggle="modal" data-bs-target="#renameModal">
                                                    <i class="fa-regular fa-clipboard me-3"></i>
                                                    Copy Keyword
                                                </button>
                                            </li>
                                            <li> <button type="button" class="dropdown-item-upload dropdown-item"
                                                    data-bs-toggle="modal" data-bs-target="#setthumbnail">
                                                    <i class="fa-solid fa-pencil me-3"></i>
                                                    SET NEW THUMBNAIL FRAME
                                                </button></li>

                                        </ul>
                                    </div>
                                    <div class="image-upload">
                                        <img src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee"
                                            alt="">
                                    </div>
                                    <div class="image-title-id">
                                        <div class="error"><i class="fa-solid fa-ban"></i></div>
                                        <div class="upload-title-img">
                                            <div class="img-title">12 Upper Galille Lorem, ipsum. </div>
                                            <div class="img-id">ID: 23870945</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="upload-image" id="upload_images">
                                    <div class="dot-menu text-end align-self-end">
                                        <button class="btn  text-start dot-dropdown dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-ellipsis-vertical "></i></button>
                                        <ul class="dropdown-menu more-detail-menu">
                                            <li>
                                                <button type="button" class="dropdown-item-upload dropdown-item"
                                                    data-bs-toggle="modal" data-bs-target="#renameModal">
                                                    <i class="fa-regular fa-clipboard me-3"></i>
                                                    Copy Keyword
                                                </button>
                                            </li>
                                            <li> <button type="button" class="dropdown-item-upload dropdown-item"
                                                    data-bs-toggle="modal" data-bs-target="#setthumbnail">
                                                    <i class="fa-solid fa-pencil me-3"></i>
                                                    SET NEW THUMBNAIL FRAME
                                                </button></li>

                                        </ul>
                                    </div>
                                    <div class="image-upload">
                                        <img src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee"
                                            alt="">
                                    </div>
                                    <div class="image-title-id">
                                        <div class="error"><i class="fa-solid fa-ban"></i></div>
                                        <div class="upload-title-img">
                                            <div class="img-title">12 Upper Galille Lorem, ipsum. </div>
                                            <div class="img-id">ID: 23870945</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="upload-image" id="upload_images">
                                    <div class="dot-menu text-end align-self-end">
                                        <button class="btn  text-start dot-dropdown dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-ellipsis-vertical "></i></button>
                                        <ul class="dropdown-menu more-detail-menu">
                                            <li>
                                                <button type="button" class="dropdown-item-upload dropdown-item"
                                                    data-bs-toggle="modal" data-bs-target="#renameModal">
                                                    <i class="fa-regular fa-clipboard me-3"></i>
                                                    Copy Keyword
                                                </button>
                                            </li>
                                            <li> <button type="button" class="dropdown-item-upload dropdown-item"
                                                    data-bs-toggle="modal" data-bs-target="#setthumbnail">
                                                    <i class="fa-solid fa-pencil me-3"></i>
                                                    SET NEW THUMBNAIL FRAME
                                                </button></li>

                                        </ul>
                                    </div>
                                    <div class="image-upload">
                                        <img src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee"
                                            alt="">
                                    </div>
                                    <div class="image-title-id">
                                        <div class="error"><i class="fa-solid fa-ban"></i></div>
                                        <div class="upload-title-img">
                                            <div class="img-title">12 Upper Galille Lorem, ipsum. </div>
                                            <div class="img-id">ID: 23870945</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="upload-image" id="upload_images">
                                    <div class="dot-menu text-end align-self-end">
                                        <button class="btn  text-start dot-dropdown dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-ellipsis-vertical "></i></button>
                                        <ul class="dropdown-menu more-detail-menu">
                                            <li>
                                                <button type="button" class="dropdown-item-upload dropdown-item"
                                                    data-bs-toggle="modal" data-bs-target="#renameModal">
                                                    <i class="fa-regular fa-clipboard me-3"></i>
                                                    Copy Keyword
                                                </button>
                                            </li>
                                            <li> <button type="button" class="dropdown-item-upload dropdown-item"
                                                    data-bs-toggle="modal" data-bs-target="#setthumbnail">
                                                    <i class="fa-solid fa-pencil me-3"></i>
                                                    SET NEW THUMBNAIL FRAME
                                                </button></li>

                                        </ul>
                                    </div>
                                    <div class="image-upload">
                                        <img src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee"
                                            alt="">
                                    </div>
                                    <div class="image-title-id">
                                        <div class="error"><i class="fa-solid fa-ban"></i></div>
                                        <div class="upload-title-img">
                                            <div class="img-title">12 Upper Galille Lorem, ipsum. </div>
                                            <div class="img-id">ID: 23870945</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="upload-image" id="upload_images">
                                    <div class="dot-menu text-end align-self-end">
                                        <button class="btn  text-start dot-dropdown dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-ellipsis-vertical "></i></button>
                                        <ul class="dropdown-menu more-detail-menu">
                                            <li>
                                                <button type="button" class="dropdown-item-upload dropdown-item"
                                                    data-bs-toggle="modal" data-bs-target="#renameModal">
                                                    <i class="fa-regular fa-clipboard me-3"></i>
                                                    Copy Keyword
                                                </button>
                                            </li>
                                            <li> <button type="button" class="dropdown-item-upload dropdown-item"
                                                    data-bs-toggle="modal" data-bs-target="#setthumbnail">
                                                    <i class="fa-solid fa-pencil me-3"></i>
                                                    SET NEW THUMBNAIL FRAME
                                                </button></li>

                                        </ul>
                                    </div>
                                    <div class="image-upload">
                                        <img src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee"
                                            alt="">
                                    </div>
                                    <div class="image-title-id">
                                        <div class="error"><i class="fa-solid fa-ban"></i></div>
                                        <div class="upload-title-img">
                                            <div class="img-title">12 Upper Galille Lorem, ipsum. </div>
                                            <div class="img-id">ID: 23870945</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="upload-image" id="upload_images">
                                    <div class="dot-menu text-end align-self-end">
                                        <button class="btn  text-start dot-dropdown dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-ellipsis-vertical "></i></button>
                                        <ul class="dropdown-menu more-detail-menu">
                                            <li>
                                                <button type="button" class="dropdown-item-upload dropdown-item"
                                                    data-bs-toggle="modal" data-bs-target="#renameModal">
                                                    <i class="fa-regular fa-clipboard me-3"></i>
                                                    Copy Keyword
                                                </button>
                                            </li>
                                            <li> <button type="button" class="dropdown-item-upload dropdown-item"
                                                    data-bs-toggle="modal" data-bs-target="#setthumbnail">
                                                    <i class="fa-solid fa-pencil me-3"></i>
                                                    SET NEW THUMBNAIL FRAME
                                                </button></li>

                                        </ul>
                                    </div>
                                    <div class="image-upload">
                                        <img src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee"
                                            alt="">
                                    </div>
                                    <div class="image-title-id">
                                        <div class="error"><i class="fa-solid fa-ban"></i></div>
                                        <div class="upload-title-img">
                                            <div class="img-title">12 Upper Galille Lorem, ipsum. </div>
                                            <div class="img-id">ID: 23870945</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="upload-image" id="upload_images">
                                    <div class="dot-menu text-end align-self-end">
                                        <button class="btn  text-start dot-dropdown dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-ellipsis-vertical "></i></button>
                                        <ul class="dropdown-menu more-detail-menu">
                                            <li>
                                                <button type="button" class="dropdown-item-upload dropdown-item"
                                                    data-bs-toggle="modal" data-bs-target="#renameModal">
                                                    <i class="fa-regular fa-clipboard me-3"></i>
                                                    Copy Keyword
                                                </button>
                                            </li>
                                            <li> <button type="button" class="dropdown-item-upload dropdown-item"
                                                    data-bs-toggle="modal" data-bs-target="#setthumbnail">
                                                    <i class="fa-solid fa-pencil me-3"></i>
                                                    SET NEW THUMBNAIL FRAME
                                                </button></li>

                                        </ul>
                                    </div>
                                    <div class="image-upload">
                                        <img src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee"
                                            alt="">
                                    </div>
                                    <div class="image-title-id">
                                        <div class="error"><i class="fa-solid fa-ban"></i></div>
                                        <div class="upload-title-img">
                                            <div class="img-title">12 Upper Galille Lorem, ipsum. </div>
                                            <div class="img-id">ID: 23870945</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="upload-image" id="upload_images">
                                    <div class="dot-menu text-end align-self-end">
                                        <button class="btn  text-start dot-dropdown dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-ellipsis-vertical "></i></button>
                                        <ul class="dropdown-menu more-detail-menu">
                                            <li>
                                                <button type="button" class="dropdown-item-upload dropdown-item"
                                                    data-bs-toggle="modal" data-bs-target="#renameModal">
                                                    <i class="fa-regular fa-clipboard me-3"></i>
                                                    Copy Keyword
                                                </button>
                                            </li>
                                            <li> <button type="button" class="dropdown-item-upload dropdown-item"
                                                    data-bs-toggle="modal" data-bs-target="#setthumbnail">
                                                    <i class="fa-solid fa-pencil me-3"></i>
                                                    SET NEW THUMBNAIL FRAME
                                                </button></li>

                                        </ul>
                                    </div>
                                    <div class="image-upload">
                                        <img src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee"
                                            alt="">
                                    </div>
                                    <div class="image-title-id">
                                        <div class="error"><i class="fa-solid fa-ban"></i></div>
                                        <div class="upload-title-img">
                                            <div class="img-title">12 Upper Galille Lorem, ipsum. </div>
                                            <div class="img-id">ID: 23870945</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="upload-image" id="upload_images">
                                    <div class="dot-menu text-end align-self-end">
                                        <button class="btn  text-start dot-dropdown dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-ellipsis-vertical "></i></button>
                                        <ul class="dropdown-menu more-detail-menu">
                                            <li>
                                                <button type="button" class="dropdown-item-upload dropdown-item"
                                                    data-bs-toggle="modal" data-bs-target="#renameModal">
                                                    <i class="fa-regular fa-clipboard me-3"></i>
                                                    Copy Keyword
                                                </button>
                                            </li>
                                            <li> <button type="button" class="dropdown-item-upload dropdown-item"
                                                    data-bs-toggle="modal" data-bs-target="#setthumbnail">
                                                    <i class="fa-solid fa-pencil me-3"></i>
                                                    SET NEW THUMBNAIL FRAME
                                                </button></li>

                                        </ul>
                                    </div>
                                    <div class="image-upload">
                                        <img src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee"
                                            alt="">
                                    </div>
                                    <div class="image-title-id">
                                        <div class="error"><i class="fa-solid fa-ban"></i></div>
                                        <div class="upload-title-img">
                                            <div class="img-title">12 Upper Galille Lorem, ipsum. </div>
                                            <div class="img-id">ID: 23870945</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="upload-image" id="upload_images">
                                    <div class="dot-menu text-end align-self-end">
                                        <button class="btn  text-start dot-dropdown dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-ellipsis-vertical "></i></button>
                                        <ul class="dropdown-menu more-detail-menu">
                                            <li>
                                                <button type="button" class="dropdown-item-upload dropdown-item"
                                                    data-bs-toggle="modal" data-bs-target="#renameModal">
                                                    <i class="fa-regular fa-clipboard me-3"></i>
                                                    Copy Keyword
                                                </button>
                                            </li>
                                            <li> <button type="button" class="dropdown-item-upload dropdown-item"
                                                    data-bs-toggle="modal" data-bs-target="#setthumbnail">
                                                    <i class="fa-solid fa-pencil me-3"></i>
                                                    SET NEW THUMBNAIL FRAME
                                                </button></li>

                                        </ul>
                                    </div>
                                    <div class="image-upload">
                                        <img src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee"
                                            alt="">
                                    </div>
                                    <div class="image-title-id">
                                        <div class="error"><i class="fa-solid fa-ban"></i></div>
                                        <div class="upload-title-img">
                                            <div class="img-title">12 Upper Galille Lorem, ipsum. </div>
                                            <div class="img-id">ID: 23870945</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="upload-image" id="upload_images">
                                    <div class="dot-menu text-end align-self-end">
                                        <button class="btn  text-start dot-dropdown dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-ellipsis-vertical "></i></button>
                                        <ul class="dropdown-menu more-detail-menu">
                                            <li>
                                                <button type="button" class="dropdown-item-upload dropdown-item"
                                                    data-bs-toggle="modal" data-bs-target="#renameModal">
                                                    <i class="fa-regular fa-clipboard me-3"></i>
                                                    Copy Keyword
                                                </button>
                                            </li>
                                            <li> <button type="button" class="dropdown-item-upload dropdown-item"
                                                    data-bs-toggle="modal" data-bs-target="#setthumbnail">
                                                    <i class="fa-solid fa-pencil me-3"></i>
                                                    SET NEW THUMBNAIL FRAME
                                                </button></li>

                                        </ul>
                                    </div>
                                    <div class="image-upload">
                                        <img src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee"
                                            alt="">
                                    </div>
                                    <div class="image-title-id">
                                        <div class="error"><i class="fa-solid fa-ban"></i></div>
                                        <div class="upload-title-img">
                                            <div class="img-title">12 Upper Galille Lorem, ipsum. </div>
                                            <div class="img-id">ID: 23870945</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="upload-image" id="upload_images">
                                    <div class="dot-menu text-end align-self-end">
                                        <button class="btn  text-start dot-dropdown dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-ellipsis-vertical "></i></button>
                                        <ul class="dropdown-menu more-detail-menu">
                                            <li>
                                                <button type="button" class="dropdown-item-upload dropdown-item"
                                                    data-bs-toggle="modal" data-bs-target="#renameModal">
                                                    <i class="fa-regular fa-clipboard me-3"></i>
                                                    Copy Keyword
                                                </button>
                                            </li>
                                            <li> <button type="button" class="dropdown-item-upload dropdown-item"
                                                    data-bs-toggle="modal" data-bs-target="#setthumbnail">
                                                    <i class="fa-solid fa-pencil me-3"></i>
                                                    SET NEW THUMBNAIL FRAME
                                                </button></li>

                                        </ul>
                                    </div>
                                    <div class="image-upload">
                                        <img src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee"
                                            alt="">
                                    </div>
                                    <div class="image-title-id">
                                        <div class="error"><i class="fa-solid fa-ban"></i></div>
                                        <div class="upload-title-img">
                                            <div class="img-title">12 Upper Galille Lorem, ipsum. </div>
                                            <div class="img-id">ID: 23870945</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="upload-image" id="upload_images">
                                    <div class="dot-menu text-end align-self-end">
                                        <button class="btn  text-start dot-dropdown dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-ellipsis-vertical "></i></button>
                                        <ul class="dropdown-menu more-detail-menu">
                                            <li>
                                                <button type="button" class="dropdown-item-upload dropdown-item"
                                                    data-bs-toggle="modal" data-bs-target="#renameModal">
                                                    <i class="fa-regular fa-clipboard me-3"></i>
                                                    Copy Keyword
                                                </button>
                                            </li>
                                            <li> <button type="button" class="dropdown-item-upload dropdown-item"
                                                    data-bs-toggle="modal" data-bs-target="#setthumbnail">
                                                    <i class="fa-solid fa-pencil me-3"></i>
                                                    SET NEW THUMBNAIL FRAME
                                                </button></li>

                                        </ul>
                                    </div>
                                    <div class="image-upload">
                                        <img src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee"
                                            alt="">
                                    </div>
                                    <div class="image-title-id">
                                        <div class="error"><i class="fa-solid fa-ban"></i></div>
                                        <div class="upload-title-img">
                                            <div class="img-title">12 Upper Galille Lorem, ipsum. </div>
                                            <div class="img-id">ID: 23870945</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="upload-image" id="upload_images">
                                    <div class="dot-menu text-end align-self-end">
                                        <button class="btn  text-start dot-dropdown dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-ellipsis-vertical "></i></button>
                                        <ul class="dropdown-menu more-detail-menu">
                                            <li>
                                                <button type="button" class="dropdown-item-upload dropdown-item"
                                                    data-bs-toggle="modal" data-bs-target="#renameModal">
                                                    <i class="fa-regular fa-clipboard me-3"></i>
                                                    Copy Keyword
                                                </button>
                                            </li>
                                            <li> <button type="button" class="dropdown-item-upload dropdown-item"
                                                    data-bs-toggle="modal" data-bs-target="#setthumbnail">
                                                    <i class="fa-solid fa-pencil me-3"></i>
                                                    SET NEW THUMBNAIL FRAME
                                                </button></li>

                                        </ul>
                                    </div>
                                    <div class="image-upload">
                                        <img src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee"
                                            alt="">
                                    </div>
                                    <div class="image-title-id">
                                        <div class="error"><i class="fa-solid fa-ban"></i></div>
                                        <div class="upload-title-img">
                                            <div class="img-title">12 Upper Galille Lorem, ipsum. </div>
                                            <div class="img-id">ID: 23870945</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="upload-image" id="upload_images">
                                    <div class="dot-menu text-end align-self-end">
                                        <button class="btn  text-start dot-dropdown dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-ellipsis-vertical "></i></button>
                                        <ul class="dropdown-menu more-detail-menu">
                                            <li>
                                                <button type="button" class="dropdown-item-upload dropdown-item"
                                                    data-bs-toggle="modal" data-bs-target="#renameModal">
                                                    <i class="fa-regular fa-clipboard me-3"></i>
                                                    Copy Keyword
                                                </button>
                                            </li>
                                            <li> <button type="button" class="dropdown-item-upload dropdown-item"
                                                    data-bs-toggle="modal" data-bs-target="#setthumbnail">
                                                    <i class="fa-solid fa-pencil me-3"></i>
                                                    SET NEW THUMBNAIL FRAME
                                                </button></li>

                                        </ul>
                                    </div>
                                    <div class="image-upload">
                                        <img src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee"
                                            alt="">
                                    </div>
                                    <div class="image-title-id">
                                        <div class="error"><i class="fa-solid fa-ban"></i></div>
                                        <div class="upload-title-img">
                                            <div class="img-title">12 Upper Galille Lorem, ipsum. </div>
                                            <div class="img-id">ID: 23870945</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="upload-image" id="upload_images">
                                    <div class="dot-menu text-end align-self-end">
                                        <button class="btn  text-start dot-dropdown dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-ellipsis-vertical "></i></button>
                                        <ul class="dropdown-menu more-detail-menu">
                                            <li>
                                                <button type="button" class="dropdown-item-upload dropdown-item"
                                                    data-bs-toggle="modal" data-bs-target="#renameModal">
                                                    <i class="fa-regular fa-clipboard me-3"></i>
                                                    Copy Keyword
                                                </button>
                                            </li>
                                            <li> <button type="button" class="dropdown-item-upload dropdown-item"
                                                    data-bs-toggle="modal" data-bs-target="#setthumbnail">
                                                    <i class="fa-solid fa-pencil me-3"></i>
                                                    SET NEW THUMBNAIL FRAME
                                                </button></li>

                                        </ul>
                                    </div>
                                    <div class="image-upload">
                                        <img src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee"
                                            alt="">
                                    </div>
                                    <div class="image-title-id">
                                        <div class="error"><i class="fa-solid fa-ban"></i></div>
                                        <div class="upload-title-img">
                                            <div class="img-title">12 Upper Galille Lorem, ipsum. </div>
                                            <div class="img-id">ID: 23870945</div>
                                        </div>
                                    </div>
                                </div> --}}


                            </div>
                            <div class="view-metadata">
                                <button type="button" class="btn btn-primary w-100 "
                                    style="font-size: 16px; padding: 15px 0;">View Metadata</button>
                            </div>
                            <div class="add-metadata">
                                <button type="button" class="btn btn-primary w-100 "
                                    style="font-size: 16px; padding: 15px 0;">Add Metadata</button>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 all-inputs">
                        <form action="" id="add_new_img_form">
                            <div class="no-file-selected">

                                <div class="no-file-selected-content">
                                    {{-- <p
                                        class="no-file-selected-title no-file-selected-title-cursor no-file-selected-display-none total_file_selected">
                                        No file selected</p> --}}
                                    <button type="button" class="btn btn-primary mobile-no-file-selcted-btn">No file
                                        selected <i class="fa-solid fa-angle-right"></i></button>
                                    <div class="no-file-template">
                                        <p class="template total_file_selected">No file selected</p>
                                        <button type="button" class="btn clear-data">Clear All Metadata</button>
                                    </div>
                                    <div class="no-file-inputs">
                                        <div class="edition-files d-none">
                                            <h5>Edition 34 Files</h5>
                                            <ul>
                                                <li>Yellow fields show information is diffrente between files</li>
                                                <li>Grey fileds show information is shared acress all files</li>
                                            </ul>
                                        </div>
                                        <div class="input-group ">
                                            <div class="file-inp-icon-grp">
                                                <input type="text" class="form-control upload-inp" name="title"
                                                    placeholder="Title *" aria-label="Username"
                                                    aria-describedby="visible-addon">
                                                <i class="fa-regular fa-circle-question file-input-icon"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Enter a title for your image."></i> <input type="hidden"
                                                    id="selected_file_id" name="file_id">
                                            </div>
                                            <label id="title-error" class="error" for="title"></label>
                                            {{-- <p>Please submit title only in English</p> --}}
                                        </div>
                                        <div class="input-group ">
                                            <div class="file-inp-icon-grp">
                                                {{-- <input type="text" class="form-control upload-inp"
                                                    placeholder="Descriptions *" name="description"
                                                    aria-label="Username" aria-describedby="visible-addon"> --}}
                                                <textarea class="form-control upload-inp upload-textarea" placeholder="Descriptions *" name="description"
                                                    aria-label="Username" aria-describedby="visible-addon"></textarea>
                                                <i class="fa-regular fa-circle-question file-input-icon"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Enter a clear description for your image."></i>
                                            </div>
                                            {{-- <p>Please submit descriptions only in English</p> --}}
                                            <label id="description-error" class="error" for="description"></label>
                                        </div>
                                        <div class="input-group ">
                                            <div class="file-inp-icon-grp">
                                                <input type="text" class="form-control upload-inp"
                                                    placeholder="Price *" name="price" aria-label="Price"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                                    aria-describedby="visible-addon">
                                                <i class="fa-regular fa-circle-question file-input-icon"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Enter a price for your image.($)"></i>
                                            </div>
                                            <label id="price-error" class="error" for="price"></label>
                                        </div>

                                        <div class="input-group file-inp-icon-grp">
                                            <input type="date" class="form-control upload-inp" name="date_created"
                                                placeholder="Date Created *" aria-label="Username"
                                                aria-describedby="visible-addon">
                                            <i class="fa-regular fa-circle-question file-input-icon"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Created date of the image."></i>
                                        </div>
                                        <div class="dropdown file-main-dropdown">
                                            <div class="file-inp-icon-grp input-group">
                                                <select class="btn w-100 text-start  file-dropdown dropdown-toggle"
                                                    name="category_id" id="category_id">
                                                    <option value="">Select Category </option>

                                                    @foreach ($category as $cas)
                                                        <option value="{{ $cas->id }}">
                                                            {{ $cas->category_name }}</option>
                                                    @endforeach


                                                </select>

                                            </div>
                                        </div>
                                        <div class="dropdown file-main-dropdown">
                                            <div class="file-inp-icon-grp input-group">
                                                <select class="btn w-100 text-start  file-dropdown dropdown-toggle"
                                                    name="collection_id" id="collection_id">
                                                    <option value="">Select Collection </option>

                                                    @foreach ($getCollections as $coll)
                                                        <option value="{{ $coll->id }}">
                                                            {{ $coll->name }}</option>
                                                    @endforeach


                                                </select>

                                            </div>
                                        </div>
                                        <div class="dropdown file-main-dropdown">
                                            <div class="file-inp-icon-grp input-group">
                                                <select class="btn w-100 text-start  file-dropdown dropdown-toggle"
                                                    name="subcategory_id" id="subcategory_id">
                                                    <option value="">Select Sub Category </option>
                                                </select>

                                            </div>
                                        </div>
                                        <div class="dropdown file-main-dropdown">
                                            <div class="file-inp-icon-grp input-group">
                                                {{-- <button class="btn w-100 text-start  file-dropdown dropdown-toggle"
                                                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Country of shoot *<i class="fa-solid fa-angle-down"></i>
                                                </button>
                                                <i class="fa-regular fa-circle-question file-input-icon"></i>

                                                <ul class="dropdown-menu file-dropdown-menu">
                                                    <li><a class="dropdown-item" href="#">Action</a></li>
                                                    <li><a class="dropdown-item" href="#">Another action</a>
                                                    </li>
                                                    <li><a class="dropdown-item" href="#">Something else
                                                            here</a></li>
                                                </ul> --}}
                                                <select class="btn w-100 text-start  file-dropdown dropdown-toggle"
                                                    name="country" id="country">
                                                    <option value="">Country of shoot </option>
                                                    {{-- <option value="usa">
                                                        USA</option>
                                                    <option value="uk">
                                                        UK</option> --}}
                                                </select>

                                            </div>
                                        </div>


                                    </div>
                                    <div class="no-file-keywording">
                                        <div class="keyword-heading">
                                            <p class="keyword-title">Keywording</p>
                                            <button type="button" class="btn d-none" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal">
                                                Language:English(US)
                                            </button>

                                        </div>
                                        <p class="keyword-sub-text">Add accurate and relevant keywords to help
                                            customers find your imagery. You can add a title to get keyword suggestions.
                                        </p>
                                        <div class="add-keyword">Add 5 to 50 Keywords : <span>0</span></div>
                                        <input name="tags" class="upload-inp form-control" id="tags"
                                            data-role="tagsinput" class="form-control">
                                        <div class="keyword-btn">
                                            {{-- <button type="button" class="btn btn-all-dark btn-hover-dark">Get
                                                SUggestions</button> --}}
                                            <button type="button"
                                                class="btn btn-all-dark btn-hover-dark copy-keywords"
                                                style="cursor: pointer;">Copy
                                                Keywords</button>
                                        </div>
                                    </div>
                                    <div class="no-file-release d-none">
                                        <p class="release-title">Release</p>
                                        <div class="update-release">
                                            <h4>We've updated our model release</h4>
                                            <p><a href="">Download enhanced version</a> and learn more about
                                                increased legal protection and licensing opportunities for you.</p>
                                        </div>
                                        <p>If you file has recognizable pepole or propertise in it, you will need to
                                            include a release with your submission</p>
                                        <p>New to release? <a href="">Checkout our release guid</a></p>
                                        <button type="button" class="btn btn-all-dark btn-hover-dark">Update
                                            release</button>
                                    </div>
                                    <div
                                        class="no-file-video-propertise {{ $batch_type == 'video' ? '' : 'd-none' }}">
                                        <p class="video-title">Video Propertise</p>
                                        <div class="input-group file-inp-label-grp">
                                            <p style="font-size: 12px;">Clip Length</p>
                                            <input type="text" class="form-control upload-inp" name="clip_length"
                                                placeholder="00:00:29:12" width="100%" aria-label="Username"
                                                aria-describedby="visible-addon" disabled>
                                        </div>
                                    </div>
                                    <div class="no-file-master-formate {{ $batch_type == 'video' ? '' : 'd-none' }}">
                                        <p class="master-title">Master Formate</p>
                                        {{-- <div class="dropdown file-main-dropdown">
                                            <div class="file-inp-icon-grp">
                                                <button class="btn w-100 text-start  file-dropdown dropdown-toggle"
                                                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Country of shoot *<i class="fa-solid fa-angle-down"></i>
                                                </button>
                                                <ul class="dropdown-menu file-dropdown-menu">
                                                    <li><a class="dropdown-item" href="#">Action</a></li>
                                                    <li><a class="dropdown-item" href="#">Another action</a>
                                                    </li>
                                                    <li><a class="dropdown-item" href="#">Something else
                                                            here</a></li>
                                                </ul>
                                            </div>
                                        </div> --}}
                                        <div class="file-master-inp-grp">
                                            {{-- <div class="input-group file-inp-label-grp">
                                                <p style="font-size: 12px;">Media formate</p>
                                                <input type="text" class="form-control upload-inp"
                                                    placeholder="Quick Time" name="media_formate" width="100%"
                                                    aria-label="Username" aria-describedby="visible-addon">
                                            </div> --}}
                                            <div class="input-group file-inp-label-grp">
                                                <p style="font-size: 12px;">Frame rate</p>
                                                <input type="text" class="form-control upload-inp"
                                                    placeholder="29.97" name="frame_rate" width="100%"
                                                    aria-label="Username" aria-describedby="visible-addon" disabled>
                                            </div>
                                        </div>
                                        <div class="file-master-inp-grp">
                                            <div class="input-group file-inp-label-grp">
                                                <p style="font-size: 12px;">Frame size</p>
                                                <input type="text" class="form-control upload-inp"
                                                    placeholder="550x550" name="frame_size" width="100%"
                                                    aria-label="Username" aria-describedby="visible-addon"disabled>
                                            </div>
                                            {{-- <div class="input-group file-inp-label-grp">
                                                <p style="font-size: 12px;">Scanning Method</p>
                                                <input type="text" class="form-control upload-inp"
                                                    placeholder="Progressive" name="scanning_method" width="100%"
                                                    aria-label="Username" aria-describedby="visible-addon">
                                            </div> --}}
                                        </div>
                                        {{-- <div class="input-group file-inp-label-grp">
                                            <p style="font-size: 12px;">Compression</p>
                                            <input type="text" class="form-control upload-inp" placeholder="H.264"
                                                name="compression" width="100%" aria-label="Username"
                                                aria-describedby="visible-addon">
                                        </div> --}}
                                    </div>

                                    <div class="no-file-master-formate {{ $batch_type == 'image' ? '' : 'd-none' }}">
                                        <p class="master-title">Image properties</p>

                                        <div class="file-master-inp-grp">
                                            <div class="input-group file-inp-label-grp">
                                                <p style="font-size: 12px;">Image Height</p>
                                                <input type="text" class="form-control upload-inp"
                                                    placeholder="Quick Time" name="image_height" width="100%"
                                                    aria-label="Username" aria-describedby="visible-addon">
                                            </div>
                                            <div class="input-group file-inp-label-grp">
                                                <p style="font-size: 12px;">Image Width</p>
                                                <input type="text" class="form-control upload-inp" placeholder=""
                                                    name="image_width" width="100%" aria-label="Username"
                                                    aria-describedby="visible-addon">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="submit-metadaata text-center mt-4 mb-1">
                                        <button type="submit" disabled id="save-metadata"
                                            class="btn btn-orange w-100 "
                                            style="font-size: 16px; padding: 15px 0;cursor: pointer;">Save
                                            metadata</button>
                                    </div>
                                </div>

                            </div>
                        </form>
                        <div class="upload-search-filter">
                            <button type="button" class="search-filter-btn btn btn-orange no-file-selected-title "
                                id="upload_close-filter">Search and Filter <i
                                    class="fa-solid fa-angle-right"></i></button>

                            <div class="filter-search-text">
                                <div class="input-search-filter flex-nowrap">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                    <input type="text" class="form-control upload-inp"
                                        placeholder="Enter Search Text" aria-describedby="addon-wrapping">
                                </div>
                            </div>
                            <div class="upload-filter-by-status">
                                <p class="status-title">Filter by status</p>
                                <ul class="status-checkbox">
                                    <li> <input class="form-check-input" type="checkbox" id="checkDefault8">

                                        <label class="form-check-label ms-3" for="checkDefault8">
                                            Accepted (0)
                                        </label>
                                    </li>
                                    <li> <input class="form-check-input" type="checkbox" value=""
                                            id="checkDefault9">
                                        <label class="form-check-label ms-3" for="checkDefault9">
                                            Accepted and Publihed (0)
                                        </label>
                                    </li>
                                    <li> <input class="form-check-input" type="checkbox" value=""
                                            id="checkDefault10">
                                        <label class="form-check-label ms-3" for="checkDefault10">
                                            Awaiting review (0)
                                        </label>
                                    </li>
                                    <li> <input class="form-check-input" type="checkbox" value=""
                                            id="checkDefault11">
                                        <label class="form-check-label ms-3" for="checkDefault11">
                                            Invalid file (0)
                                        </label>
                                    </li>
                                    <li> <input class="form-check-input" type="checkbox" value=""
                                            id="checkDefault12">
                                        <label class="form-check-label ms-3" for="checkDefault12">
                                            Processing (0)
                                        </label>
                                    </li>
                                    <li> <input class="form-check-input" type="checkbox" value=""
                                            id="checkDefault13">
                                        <label class="form-check-label ms-3" for="checkDefault13">
                                            Queued for upload (0)
                                        </label>
                                    </li>
                                    <li> <input class="form-check-input" type="checkbox" value=""
                                            id="checkDefault14">
                                        <label class="form-check-label ms-3" for="checkDefault14">
                                            Signature plus nominated (0)
                                        </label>
                                    </li>
                                    <li> <input class="form-check-input" type="checkbox" value=""
                                            id="checkDefault15">
                                        <label class="form-check-label ms-3" for="checkDefault15">
                                            REady to submit (0)
                                        </label>
                                    </li>
                                    <li> <input class="form-check-input" type="checkbox" value=""
                                            id="checkDefault16">
                                        <label class="form-check-label ms-3" for="checkDefault16">
                                            Revisible (0)
                                        </label>
                                    </li>
                                    <li> <input class="form-check-input" type="checkbox" value=""
                                            id="checkDefault17">
                                        <label class="form-check-label ms-3" for="checkDefault17">
                                            Rejected (0)
                                        </label>
                                    </li>
                                    <li> <input class="form-check-input" type="checkbox" value=""
                                            id="checkDefault18">
                                        <label class="form-check-label ms-3" for="checkDefault18">
                                            Uploaded filed (0)
                                        </label>
                                    </li>
                                    <li> <input class="form-check-input" type="checkbox" value=""
                                            id="checkDefault19">
                                        <label class="form-check-label ms-3" for="checkDefault19">
                                            Uploading (0)
                                        </label>
                                    </li>
                                    <li> <input class="form-check-input" type="checkbox" value=""
                                            id="checkDefault20">
                                        <label class="form-check-label ms-3" for="checkDefault20">
                                            Work in progress (0)
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ── Toast Card ── -->
    <div class="upload-toast" id="uploadToast">
        <div class="toast-header">
            <div class="toast-left">
                <!-- spinner -->
                <div class="spin-ring" id="spinRing">
                    <svg viewBox="0 0 36 36" fill="none">
                        <circle class="track" cx="18" cy="18" r="15" stroke-width="3" />
                        <circle class="arc" cx="18" cy="18" r="15" stroke-width="3"
                            stroke-dashoffset="0" transform="rotate(-90 18 18)" />
                    </svg>
                </div>
                <!-- success check (hidden initially) -->
                <div class="check-ring" id="checkRing">
                    <svg viewBox="0 0 36 36" fill="none">
                        <circle cx="18" cy="18" r="15" fill="#4ade80" opacity=".15" />
                        <circle cx="18" cy="18" r="15" stroke="#4ade80" stroke-width="2.5" />
                        <polyline points="11,18 16,23 25,13" stroke="#4ade80" stroke-width="2.5"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>

                <div>
                    <div class="toast-title" id="toastTitle">Uploading...</div>
                    <div class="toast-subtitle" id="toastSub" id="toastSub">
                        Image upload in progress
                    </div>
                </div>
            </div>

            <div class="toast-thumb" id="toastThumb">
                {{-- <img id="thumbImg" src="" alt="" /> --}}
                <i class="fa-solid fa-arrow-up-from-bracket"></i>
            </div>
        </div>

        <div class="bar-wrap">
            <div class="bar-fill" id="barFill"></div>
        </div>

        <div class="toast-footer">
            <div class="wait-text" id="waitText">Please wait</div>
            <div class="counter-box" id="counterBox">
                <div class="counter-num" id="pctLabel">0</div>
                <div class="counter-sym">%</div>
            </div>
            <div class="success-msg" id="successMsg">Upload complete ✓</div>
        </div>
    </div>
</div>

<div class="modal fade" id="setthumbnail" tabindex="-1" aria-labelledby="setthumbnail" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <form action="">
                <div class="modal-header  m-auto ">
                    <h5 class="modal-title" id="renameModalLabel" style="font-size: 16px;">Enter a time from your
                        video to set a thumbnail frame </h5>
                </div>

                <div class="modal-body ">
                    <label class="form-label">Set thumbnail at</label>
                    <input type="text" class="form-control" placeholder="00:00:15:21">
                </div>

                <div class="modal-footer text-center m-auto">
                    <button type="button" class="btn btn-all-dark btn-hover-dark" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="button" class="btn btn-orange">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="BatchrenameModal" tabindex="-1" aria-labelledby="renameModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="">
                <div class="modal-header">
                    <h5 class="modal-title" id="renameModalLabel">Rename Item</h5>
                </div>
                <input type="hidden" name="batch_id" id="rename_batch_id">

                <div class="modal-body">
                    <label class="form-label">Batch Name</label>
                    <input type="text" class="form-control batch-inp" id="rename_batch_name"
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

<div class="modal fade" id="BatchNotModal" tabindex="-1" aria-labelledby="renameModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="">
                <div class="modal-header">
                    {{-- <h5 class="modal-title" id="renameModalLabel">Add or edit note for inspectors</h5> --}}
                </div>

                <div class="modal-body">
                    <label class="modal-label">Note</label>
                    <textarea class="form-control batch-inp" placeholder="Leave a comment here" id="floatingTextarea" rows="4"></textarea>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-all-dark btn-hover-dark" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="button" class="btn btn-orange">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
