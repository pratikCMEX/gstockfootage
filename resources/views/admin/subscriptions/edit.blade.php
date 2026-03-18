<div class="body-wrapper-inner">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4"><a class="card-title fw-semibold mb-4"
                        href="{{ route('admin.subscriptions') }}">Subscription Plan list</a>/Edit Subscription Plan</h5>

                <div class="card">
                    <div class="card-body">
                        <form id="subscription_form" method="POST" action="{{ route('admin.subscription_update') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <input type="hidden" name="subscription_plan_id" id="subscription_plan_id"
                                    value="{{ encrypt($getSubscriptionPlanDetail->id) }}">
                                <label for="exampleInputEmail1" class="form-label">Plan Name</label><label class="text-danger">*</label>
                                <input type="text" name="name" class="form-control" id="name"
                                    value="{{ $getSubscriptionPlanDetail->name }}" aria-describedby="emailHelp"
                                    placeholder="Please enter license name">
                            </div>
                            <div class="mb-3">
                                <label for="category" class="form-label">Duration Type</label><label class="text-danger">*</label>
                                <select class="form-select mr-sm-2" name="duration_type" id="duration_tye">
                                    <option value="">Choose Duration...</option>
                                    <option value="Month" {{ ($getSubscriptionPlanDetail->duration_type ?? '') == 'Month' ? 'selected' : '' }}>Month</option>
                                    <option value="Quarter" {{ ($getSubscriptionPlanDetail->duration_type ?? '') == 'Quarter' ? 'selected' : '' }}>Quarter</option>
                                    <option value="Year" {{ ($getSubscriptionPlanDetail->duration_type ?? '') == 'Year' ? 'selected' : '' }}>Year</option>

                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Duration value</label><label class="text-danger">*</label>
                                <input type="text" name="duration_value" class="form-control" id="duration_value"
                                    value="{{ $getSubscriptionPlanDetail->duration_value }}"
                                    aria-describedby="emailHelp" placeholder="Please enter duration value"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Total Clips</label><label class="text-danger">*</label>
                                <input type="text" name="total_clips" class="form-control" id="total_clips"
                                    value="{{ $getSubscriptionPlanDetail->total_clips }}" aria-describedby="emailHelp"
                                    placeholder="Please enter total clips"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Discount(%)</label>
                                <input type="text" name="discount" class="form-control" id="discount"
                                    value="{{ $getSubscriptionPlanDetail->discount_percentage }}"
                                    aria-describedby="emailHelp" placeholder="Please enter total clips"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                            </div>

                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Price</label><label class="text-danger">*</label>
                                <input type="text" name="price" class="form-control" id="price"
                                    value="{{ $getSubscriptionPlanDetail->price }}" aria-describedby="emailHelp"
                                    placeholder="Please enter price"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                            </div>


                            <button type="submit" class="btn btn-orange">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>