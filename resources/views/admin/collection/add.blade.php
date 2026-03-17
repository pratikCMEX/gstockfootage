<div class="body-wrapper-inner">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4"><a class="card-title fw-semibold mb-4"
                        href="{{ route('admin.collection') }}">Collection list</a>/Add Collection</h5>

                <div class="card">
                    <div class="card-body">
                        <form id="add_collection_form" method="POST" action="{{ route('admin.collection_store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Collection Name</label><label class="text-danger">*</label>
                                <input type="text" name="name" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" placeholder="Please enter collection name">
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Upload Image</label><label class="text-danger">*</label>
                                <input class="form-control" type="file" name="image" id="image"
                                    accept="image/*" onchange="loadFile(event)">


                                <div class="mt-2 row">
                                    <div class="col-sm-4">
                                        <img src="" id="preview_image" alt=""
                                            class="img-fluid rounded-4 mb-2 mb-sm-0">
                                    </div>

                                </div>

                            </div>
                            <button type="submit" class="btn btn-orange">Add</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
