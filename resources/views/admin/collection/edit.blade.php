{{-- {{ dd($getcollectionDetail) }} --}}
<div class="body-wrapper-inner">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4"><a class="card-title fw-semibold mb-4"
                        href="{{ route('admin.collection') }}">Collection list</a>/Edit collection</h5>
                <div class="card">
                    <div class="card-body">
                        <form id="edit_collection_form" method="POST"
                            action="{{ route('admin.collection_update') }}"enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="collection_name" class="form-label">Collection Name</label>
                                <input type="hidden" name="collection_id" id="collection_id"
                                    value="{{ encrypt($getCollectionDetail->id) }}" />
                                <input type="text" name="name" class="form-control" id="name"
                                    placeholder="Please enter collection name" value="{{ $getCollectionDetail->name }}">
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Upload Image</label>
                                <input class="form-control" type="file" name="image" id="image"
                                    onchange="loadFile(event)">


                                <div class="mt-2 row">
                                    <div class="col-sm-4">
                                        <img src="{{ asset('uploads/images/collection/' . $getCollectionDetail->image) }}"
                                            id="preview_image" alt="" class="img-fluid rounded-4 mb-2 mb-sm-0">
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
