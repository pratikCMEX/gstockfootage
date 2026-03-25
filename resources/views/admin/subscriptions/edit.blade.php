<div class="body-wrapper-inner">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4"><a class="card-title fw-semibold mb-4"
                        href="{{ route('admin.subscriptions') }}">Subscription Plans</a> / Edit Subscription Plan</h5>

                <div class="card">
                    <div class="card-body">
                        <form id="subscription_form" method="POST" action="{{ route('admin.subscription_update') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6 col-12 mb-3">
                                    <input type="hidden" name="subscription_plan_id" id="subscription_plan_id"
                                        value="{{ encrypt($getSubscriptionPlanDetail->id) }}">
                                    <label for="exampleInputEmail1" class="form-label">Subscription Plan
                                        Name</label><label class="text-danger">*</label>
                                    <input type="text" name="name" class="form-control" id="name"
                                        value="{{ $getSubscriptionPlanDetail->name }}" aria-describedby="emailHelp"
                                        placeholder=" enter license name">
                                </div>
                                <div class="col-sm-6 col-12 mb-3">
                                    <label for="category" class="form-label">Duration Type</label><label
                                        class="text-danger">*</label>
                                    <select class="form-select mr-sm-2" name="duration_type" id="duration_tye">
                                        <option value="">Choose Duration Type...</option>
                                        <option value="Month"
                                            {{ strtolower($getSubscriptionPlanDetail->duration_type ?? '') == 'month' ? 'selected' : '' }}>
                                            Month</option>
                                        <option value="Quarter"
                                            {{ strtolower($getSubscriptionPlanDetail->duration_type ?? '') == 'quarter' ? 'selected' : '' }}>
                                            Quarter</option>
                                        <option value="Year"
                                            {{ strtolower($getSubscriptionPlanDetail->duration_type ?? '') == 'year' ? 'selected' : '' }}>
                                            Year</option>

                                    </select>
                                </div>
                                <div class="col-sm-6 col-12 mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Duration value</label><label
                                        class="text-danger">*</label>
                                    <input type="text" name="duration_value" class="form-control" id="duration_value"
                                        value="{{ $getSubscriptionPlanDetail->duration_value }}"
                                        aria-describedby="emailHelp" placeholder=" enter duration value"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                                </div>
                                <div class="col-sm-6 col-12 mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Total Clips</label><label
                                        class="text-danger">*</label>
                                    <input type="text" name="total_clips" class="form-control" id="total_clips"
                                        value="{{ $getSubscriptionPlanDetail->total_clips }}"
                                        aria-describedby="emailHelp" placeholder=" enter total clips"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                                </div>
                                <div class="col-sm-6 col-12 mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Discount(%)</label>
                                    <input type="text" name="discount" class="form-control" id="discount"
                                        value="{{ $getSubscriptionPlanDetail->discount_percentage }}"
                                        aria-describedby="emailHelp" placeholder=" enter total clips"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                                </div>

                                <div class="col-sm-6 col-12 mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Price ($)</label><label
                                        class="text-danger">*</label>
                                    <input type="text" name="price" class="form-control" id="price"
                                        value="{{ $getSubscriptionPlanDetail->price }}" aria-describedby="emailHelp"
                                        placeholder=" enter price"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-orange">Edit Subscription Plan</button>
                            <a href="{{ route('admin.subscriptions') }}" class="btn btn-orange">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
