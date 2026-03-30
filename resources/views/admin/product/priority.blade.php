<div class="body-wrapper-inner">
    <div class="container-fluid">

        <!-- PAGE HEADER -->
        <div class="row mb-4 align-items-center">

            <div class="col-md-4">
                <h5 class="card-title fw-semibold mb-4"><a class="card-title fw-semibold mb-4" href=""> </a> Product
                    Priority</h5>
                <!-- <h5 class="card-title fw-semibold">
                    <a href="{{ route('admin.product') }}">Product List</a> / Priority
                </h5> -->
            </div>

            <div class="col-md-8 text-end">

                <button id="MoveToPriority" class="btn btn-primary d-none">
                    Move to Priority
                </button>

                <button id="MoveToAllProducts" class="btn btn-primary d-none">
                    Move to All Products
                </button>

                <button id="emptyPriorityList" class="btn btn-primary">
                    Empty Priority List
                </button>

                <button id="savePriority" class="btn btn-primary">
                    Save
                </button>
                <!-- <a href="{{ route('admin.product') }}" id="savePriority" class="btn btn-dark">
                    Cancle
                </a> -->

            </div>

        </div>


        <!-- MAIN CONTENT -->
        <div class="row">

            <!-- ALL PRODUCTS -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">

                        <h5 class="card-title mb-3">All Products</h5>

                        <div class="mb-2">
                            <select id="filterProductType" class="form-control form-control-md">

                                <option value="image">Images</option>
                                <option value="video">Videos</option>
                            </select>
                        </div>
                        <div class="table-scroll">
                            <div class="mb-2">
                                <input type="text" id="searchAllProducts" class="form-control form-control-md"
                                    placeholder="Search products...">
                            </div>

                            <table class="table table-bordered table-sm" id="all-products-table">

                                <thead class="table-light text-center">
                                    <tr>
                                        <th><input Type='checkbox' name="allPriority" id='allPriority'></th>
                                        <th>Sr. No.</th>
                                        <th>Product Name</th>
                                        <th width="80">Type</th>
                                        <th width="110">Preview</th>
                                        <th width="80">Price ($)</th>
                                    </tr>
                                </thead>

                                <tbody id="all-products">
                                    @php
                                        $i = 0;
                                        $cloudfront = 'https://d3cz6emnvl4l6h.cloudfront.net/';

                                    @endphp
                                    @foreach ($products as $product)
                                        @php
                                            $i++;
                                        @endphp

                                        @php
                                            $thumbnail = $product->thumbnail_path
                                                ? $cloudfront . $product->thumbnail_path
                                                : asset('assets/admin/images/demo_thumbnail.png');

                                            $videoUrl = $cloudfront . $product->file_path;
                                        @endphp

                                        <tr data-id="{{ $product->id }}">
                                            <td><input Type='checkbox' name="selectPriority" id='selectPriority'
                                                    value="{{ $product->id }}"></td>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $product->title }}</td>
                                            <td>{{ $product->type }}</td>

                                            <td>

                                                @if ($product->type === 'image')
                                                    <img src="{{ $product->mid_path ? $cloudfront . $product->mid_path : '' }}"
                                                        class="preview-image"
                                                        data-src="{{ $cloudfront . $product->file_path }}"
                                                        width="70" height="70" style="cursor:pointer">
                                                @else
                                                    <div
                                                        class="video-thumbnail-wrapper position-relative d-inline-block">

                                                        <img src="{{ $thumbnail }}" width="90" height="90"
                                                            class="video-thumbnail rounded"
                                                            data-video="{{ $videoUrl }}">

                                                        <i class="ti ti-player-play play-icon video-thumbnail"
                                                            data-video="{{ $videoUrl }}"></i>

                                                    </div>
                                                @endif

                                            </td>

                                            <td>{{ $product->price }}</td>

                                        </tr>
                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    </div>
                </div>
            </div>



            <!-- PRIORITY AREA -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">

                        <h5 class="card-title mb-3">Priority List</h5>
                        <div class="table-scroll">

                            <div class="mb-2">
                                <input type="text" id="searchPriorityProducts" class="form-control form-control-md"
                                    placeholder="Search priority products...">
                            </div>
                            <table class="table table-bordered table-sm" id="priority-table">

                                <thead class="table-light text-center">
                                    <tr>
                                        <th><input type="checkbox" id="allPrioritySelected"></th>
                                        <th width="70">Priority</th>
                                        <th>Product Name</th>

                                        <th width="80">Type</th>
                                        <th width="110">Preview</th>
                                        <th width="80">Price ($)</th>
                                    </tr>
                                </thead>

                                <tbody id="priority-products">

                                    @foreach ($priorityProducts as $product)
                                        @php
                                            $thumbnail = $product->thumbnail_path
                                                ? $cloudfront . $product->thumbnail_path
                                                : asset('assets/admin/images/demo_thumbnail.png');

                                            $videoUrl = $cloudfront . $product->file_path;
                                        @endphp

                                        <tr data-id="{{ $product->id }}">
                                            <td><input type="checkbox" class="priorityCheck"
                                                    value="{{ $product->id }}">
                                            </td>
                                            <td class="priority-number">{{ $product->priority }}</td>



                                            <td>{{ $product->title }}</td>

                                            <td>{{ $product->type }}</td>

                                            <td>

                                                @if ($product->type === 'image')
                                                    <img src="{{ $product->mid_path ? $cloudfront . $product->mid_path : '' }}"
                                                        width="70" height="70">
                                                @else
                                                    <div
                                                        class="video-thumbnail-wrapper position-relative d-inline-block">

                                                        <img src="{{ $thumbnail }}" width="90" height="90">

                                                        <i class="ti ti-player-play play-icon"></i>

                                                    </div>
                                                @endif

                                            </td>

                                            <td>{{ $product->price }}</td>

                                        </tr>
                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
