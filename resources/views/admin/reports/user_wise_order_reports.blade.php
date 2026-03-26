<div class="body-wrapper-inner">
    <div class="container-fluid">
        <div class="mb-3 mb-sm-0 mb-4">
            <h5 class="card-title fw-semibold">Reports / User Wise Orders</h5>
        </div>
        <div class="row mb-3 table-date">
             <div class="col-md-3">
                <label>Users</label>
                <select name="user_id" id="user_id" class="form-control searchable">
                    <option value="" selected>All</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->first_name . ' ' . $user->last_name }}</option>

                    @endforeach
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