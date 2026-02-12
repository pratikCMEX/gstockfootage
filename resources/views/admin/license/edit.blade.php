<div class="body-wrapper-inner">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4"><a class="card-title fw-semibold mb-4"
                        href="{{ route('admin.license') }}">License list</a>/Edit License</h5>

                <div class="card">
                    <div class="card-body">
                        <form id="license_form" method="POST" action="{{ route('admin.license_update') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <input type="hidden" name="license_id" id="license_id" value="{{ encrypt($getLicenseDetail->id) }}">
                                <label for="exampleInputEmail1" class="form-label">License Name</label>
                                <input type="text" name="name" class="form-control" id="name" value="{{ $getLicenseDetail->name }}"
                                    aria-describedby="emailHelp" placeholder="Please enter license name">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Title</label>
                                <input type="text" name="title" class="form-control" id="title" value="{{ $getLicenseDetail->title }}"
                                    aria-describedby="emailHelp" placeholder="Please enter title">
                            </div>
                             <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Quality</label>
                                <input type="text" name="quality" class="form-control" id="quality"  value="{{ $getLicenseDetail->quality }}"
                                    aria-describedby="emailHelp" placeholder="Please enter quality">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Price</label>
                                <input type="text" name="price" class="form-control" id="price" value="{{ $getLicenseDetail->price }}"
                                    aria-describedby="emailHelp" placeholder="Please enter price" 
                                     oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                            </div>
                            
                            <div class="mb-3">
                                 <label for="exampleInputEmail1" class="form-label">Description</label>
                                <textarea class="form-control" name="description" id="description">{{ $getLicenseDetail->description }}</textarea>
                            </div>
                            

                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
