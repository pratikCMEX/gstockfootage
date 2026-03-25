<div class="body-wrapper-inner">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4"><a class="card-title fw-semibold mb-4"
                        href="{{ route('admin.video') }}">Video list</a>/Add Video</h5>
                <div class="card">
                    <div class="card-body">
                        <form id="edit_video_form" method="POST"
                            action="{{ route('admin.video_update', encrypt($getVideoDetail->id)) }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="category" class="form-label">Category</label>
                                <select class="form-select mr-sm-2" name="category" id="category">
                                    @foreach ($category as $cat)
                                        <option value="{{ $cat->id }}"
                                            {{ $getVideoDetail->category_id == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                             <div class="mb-3">
                                <label class="form-label">SubCategory</label>
                                <select class="form-select" name="subcategory" id="subcategory">
                                    {{-- <option value="" selected disabled>Choose SubCategory...</option> --}}

                                    @foreach ($subcategories as $sub)
                                        <option value="{{ $sub->id }}"
                                            {{ $getVideoDetail->subcategory_id == $sub->id ? 'selected' : '' }}>
                                            {{ $sub->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="category" class="form-label">Collection</label>
                                <select class="form-select" name="collection" id="collection">
                                    @foreach ($collections as $coll)
                                        <option value="{{ $coll->id }}"
                                            {{ $getVideoDetail->collection_id == $coll->id ? 'selected' : '' }}>
                                            {{ $coll->name }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="mb-3">
                                <label for="video_name" class="form-label">Video Name</label>
                                <input type="text" name="video_name" class="form-control" id="video_name"
                                    aria-describedby="emailHelp" value="{{ $getVideoDetail->video_name }}"
                                    placeholder="enter video name">
                            </div>
                            <div class="mb-3">
                                <label for="video_price" class="form-label">Video Price</label>
                                <input type="text" name="video_price" class="form-control" id="video_price"
                                    aria-describedby="emailHelp" placeholder="enter video price"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                    value="{{ $getVideoDetail->video_price }}">
                            </div>
                            <div class="mb-3">
                                <label for="video_description" class="form-label">Video Description</label>
                                <textarea class="form-control" name="video_description" id="video_description"rows="3">{{ $getVideoDetail->video_description }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="tags" class="form-label">Tags</label>
                                <input type="text" id="tags" name="tags" class="form-control"
                                    value="{{ $getVideoDetail->tags }}" data-role="tagsinput" />
                            </div>
                            <div class="mb-3">
                                <label for="video" class="form-label">Upload video</label>
                                <input class="form-control" type="file" name="video" id="video"
                                    accept="video/mp4,video/x-m4v,video/*" onchange="previewVideo(event)">


                                <div class="mt-2 row">
                                    <div class="col-sm-4">
                                        <video id="preview_video" width="100%" height="auto" controls
                                            class="rounded-4 mb-2 mb-sm-0" style="">
                                            <source
                                                src="{{ asset('uploads/videos/high/' . $getVideoDetail->high_path) }}"
                                                type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    </div>
                                    {{-- <div class="col-sm-6">
                                                <img src="../assets/images/products/s4.jpg" alt="modernize-img"
                                                    class="img-fluid rounded-4">
                                            </div> --}}
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
