<div class="body-wrapper-inner">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4"><a class="card-title fw-semibold mb-4"
                        href="javascript::void(0);">Login Background</a></h5>

                <div class="card">
                    <div class="card-body">
                        <form id="add_banner_form" method="POST" action="{{ route('admin.banner_store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Title</label><label for=""
                                    class="text-danger">*</label>
                                <input type="text" name="title" id="title" class="form-control"
                                    value="{{ $banner->title ?? '' }}" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" placeholder="enter title">
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Upload Image</label><label for=""
                                    class="text-danger">*</label>
                                <input class="form-control" type="file" name="image" id="image"
                                    accept="image/*" onchange="loadFile(event)">

                                @php
                                    $image = '';
                                    if (!empty($banner) && $banner->image != '') {
                                        $image = asset('uploads/banners/' . $banner->image);
                                    }
                                @endphp
                                <span style="font-size: 12px;">(Image must be at least 1920x1080 pixels for proper
                                    display.)</span>
                                <div class="mt-2 row">
                                    <div class="col-sm-6">
                                        <img src="{{ $image }}" id="preview_image" alt=""
                                            class="img-fluid rounded-4 mb-2 mb-sm-0">
                                    </div>

                                </div>

                            </div>
                            <button type="submit" class="btn btn-orange">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
