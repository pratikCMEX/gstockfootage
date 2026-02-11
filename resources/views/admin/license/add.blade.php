<div class="body-wrapper-inner">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4"><a class="card-title fw-semibold mb-4"
                        href="{{ route('admin.license') }}">License list</a>/Add License</h5>

                <div class="card">
                    <div class="card-body">
                        <form id="add_license_form" method="POST" action="{{ route('admin.store_license') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">License Name</label>
                                <input type="text" name="name" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" placeholder="Please enter license name">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Title</label>
                                <input type="text" name="title" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" placeholder="Please enter title">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Price</label>
                                <input type="text" name="price" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" placeholder="Please enter price">
                            </div>
                            <div class="mb-3">
                                 <label for="exampleInputEmail1" class="form-label">Description</label>
                                <textarea class="form-control" name="description"></textarea>
                            </div>
                            

                            <button type="submit" class="btn btn-primary">Add</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
