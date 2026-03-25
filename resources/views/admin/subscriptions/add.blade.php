<div class="body-wrapper-inner">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4"><a class="card-title fw-semibold mb-4"
                        href="{{ route('admin.subscriptions') }}">Subscription Plans</a> / Add Subscription Plan</h5>

                <div class="card">
                    <div class="card-body">
                        <form id="subscription_form" method="POST" action="{{ route('admin.subscription_store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Subscription Plan Name</label><label class="text-danger">*</label>
                                <input type="text" name="name" class="form-control" id="name"
                                    aria-describedby="emailHelp" placeholder="Please enter subscriptin plan name">
                            </div>
                            <div class="mb-3">
                                <label for="category" class="form-label">Duration Type</label><label class="text-danger">*</label>
                                <select class="form-select mr-sm-2" name="duration_type" id="duration_tye">
                                    <option value="">Choose Duration Type...</option>
                                    <option value="Month">Month</option>
                                    <option value="Quarter">Quarter</option>
                                    <option value="Year">Year</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Duration value</label><label class="text-danger">*</label>
                                <input type="text" name="duration_value" class="form-control" id="duration_value"
                                    aria-describedby="emailHelp" placeholder="Please enter duration value"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Total Clips</label><label class="text-danger">*</label>
                                <input type="text" name="total_clips" class="form-control" id="total_clips"
                                    aria-describedby="emailHelp" placeholder="Please enter total clips"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Discount(%)</label>
                                <input type="text" name="discount" class="form-control" id="discount"
                                    aria-describedby="emailHelp" placeholder="Please enter Discount"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                            </div>

                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Price ($)</label><label class="text-danger">*</label>
                                <input type="text" name="price" class="form-control" id="price"
                                    aria-describedby="emailHelp" placeholder="Please enter price"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                            </div>


                            <button type="submit" class="btn btn-orange">Add Subscription Plan</button>
                            <a href="{{ route('admin.subscriptions') }}" class="btn btn-orange">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>