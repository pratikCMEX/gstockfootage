{{-- {{ dd($getcollectionDetail) }} --}}
<div class="body-wrapper-inner">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4"><a class="card-title fw-semibold mb-4"
                        href="{{ route('admin.collection') }}">Collection</a> / Edit Collection</h5>
                <div class="card">
                    <div class="card-body">
                        <form id="edit_collection_form" method="POST"
                            action="{{ route('admin.collection_update') }}"enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6 col-12 mb-3">
                                    <label for="collection_name" class="form-label">Collection Name</label><label
                                        class="text-danger">*</label>
                                    <input type="hidden" name="collection_id" id="collection_id"
                                        value="{{ encrypt($getCollectionDetail->id) }}" />
                                    <input type="text" name="name" class="form-control" id="name"
                                        placeholder=" enter collection name" value="{{ $getCollectionDetail->name }}">
                                </div>
                                <div class="col-sm-6 col-12 mb-3">
                                    <label for="image" class="form-label">Upload Image</label><label
                                        class="text-danger">*</label>
                                    <input class="form-control" type="file" name="image" id="image"
                                        accept="image/*" onchange="loadFile(event)">


                                    <div class="mt-2 row">
                                        <div class="col-sm-4">
                                            <img src="{{ asset('uploads/images/collection/' . $getCollectionDetail->image) }}"
                                                id="preview_image" alt=""
                                                class="img-fluid rounded-4 mb-2 mb-sm-0">
                                        </div>
                                        {{-- <div class="col-sm-6">
                                                <img src="../assets/images/products/s4.jpg" alt="modernize-img"
                                                    class="img-fluid rounded-4">
                                            </div> --}}
                                    </div>

                                </div>
                            </div>
                            <button type="submit" class="btn btn-orange mt-4">Edit Collection</button>
                            <a href="{{ route('admin.collection') }}" class="btn btn-orange mt-4">Cancel</a>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
