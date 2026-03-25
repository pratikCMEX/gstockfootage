<div class="body-wrapper-inner">
    <div class="container-fluid">
        <div class="mb-3 mb-sm-0 mb-4">
            <h5 class="card-title fw-semibold mb-4">User Subscriptions</h5>
        </div>
        <div class="row mb-3 table-date">
            <div class="col-md-3">
                <label> Status</label>
                <select class="form-control" name="status" id="status">
                    <option value="" selected disabled>All</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="expired">Expired</option>
                    <option value="cancelled">Cancelled</option>

                </select>

            </div>
            <div class="col-md-3">
                <label>Payment Status</label>
                <select class="form-control" name="payment_status" id="payment_status">
                    <option value="" selected disabled>All</option>
                    <option value="pending">Pending</option>
                    <option value="success">Sucess</option>
                    <option value="failed">Failed</option>

                </select>

            </div>
            <div class="col-md-3">
                <label>From Date</label>
                <input type="date" id="from_date" class="form-control">
            </div>
            <div class="col-md-3">
                <label>To Date</label>
                <input type="date" id="to_date" class="form-control">
            </div>

        </div>

        <div class="row">
            <div class="col-lg-12 d-flex align-items-stretch">

                <div class="card w-100">
                    <div class="card-body">

                        <div class="table-responsive">

                            {{ $dataTable->table() }}
                        </div>
                        {{ $dataTable->scripts() }}

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>