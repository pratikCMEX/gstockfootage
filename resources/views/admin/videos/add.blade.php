<div class="body-wrapper-inner">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4"><a class="card-title fw-semibold mb-4"
                        href="{{ route('admin.video') }}">Video list</a>/Add Video</h5>
                <div class="card">
                    <div class="card-body">
                        <form id="add_video_form" method="POST" action="{{ route('admin.video_store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="category" class="form-label">Category</label>
                                <select class="form-select mr-sm-2" name="category" id="category">
                                    <option value="">Choose Category...</option>
                                    @foreach ($category as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="video_name" class="form-label">Video Name</label>
                                <input type="text" name="video_name" class="form-control" id="video_name"
                                    aria-describedby="emailHelp" placeholder="Please enter video name">
                            </div>
                            <div class="mb-3">
                                <label for="video_price" class="form-label">Video Price</label>
                                <input type="text" name="video_price" class="form-control" id="video_price"
                                    aria-describedby="emailHelp" placeholder="Please enter video price"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                            </div>
                            <div class="mb-3">
                                <label for="video_description" class="form-label">Video Description</label>
                                <textarea class="form-control" name="video_description" id="video_description"rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="tags" class="form-label">Tags</label>
                                <input type="text" id="tags" name="tags" class="form-control"
                                    data-role="tagsinput" />
                            </div>
                            <div class="mb-3">
                                <label for="video" class="form-label">Upload video</label>
                                <input class="form-control" type="file" name="video" id="video"
                                    accept="video/mp4,video/x-m4v,video/*" onchange="previewVideo(event)">


                                <div class="mt-2 row">
                                    <div class="col-sm-4">
                                        <video id="preview_video" width="100%" height="auto" controls
                                            class="rounded-4 mb-2 mb-sm-0" style="display:none;">
                                            <source src="" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    </div>
                                    {{-- <div class="col-sm-6">
                                                <img src="../assets/images/products/s4.jpg" alt="modernize-img"
                                                    class="img-fluid rounded-4">
                                            </div> --}}
                                </div>

                            </div>
                            <button type="submit" class="btn btn-primary">Add</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
