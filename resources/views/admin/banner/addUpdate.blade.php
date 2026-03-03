<div class="body-wrapper-inner">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4"><a class="card-title fw-semibold mb-4"
                        href="{{ route('admin.collection') }}">Login Banner</a></h5>

                <div class="card">
                    <div class="card-body">
                        <form id="add_banner_form" method="POST" action="{{ route('admin.banner_store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Title</label>
                                <input type="text" name="title" id="title" class="form-control"
                                    value="{{ $banner->title ?? '' }}" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" placeholder="Please enter collection name">
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Upload Image</label>
                                <input class="form-control" type="file" name="image" id="image"
                                    accept="image/*" onchange="loadFile(event)">

                                @php
                                    $image = '';
                                    if (!empty($banner) && $banner->image != '') {
                                        $image = asset('uploads/banners/' . $banner->image);
                                    }
                                @endphp

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
