<div class="body-wrapper-inner">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4"><a class="card-title fw-semibold mb-4"
                        href="{{ route('admin.user') }}">Users</a> / Add User</h5>
                <div class="card">
                    <div class="card-body">
                        <form id="add_user_form" method="POST" action="{{ route('admin.user_store') }}">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6 col-12 mb-3">
                                    <label for="first_name" class="form-label">First Name</label>
                                    <input type="text" name="first_name" class="form-control" id="first_name"
                                        placeholder=" enter first name">
                                </div>
                                <div class="col-sm-6 col-12 mb-3">
                                    <label for="last_name" class="form-label">Last Name</label>
                                    <input type="text" name="last_name" class="form-control" id="last_name"
                                        placeholder=" enter last name">
                                </div>
                                <div class="col-sm-6 col-12 mb-3">
                                    <label for="email" class="form-label">Email</label><label
                                        class="text-danger">*</label>
                                    <input type="email" name="email" class="form-control" id="email"
                                        placeholder=" enter email">
                                </div>
                                <div class="col-sm-6 col-12 mb-3">
                                    <label for="password" class="form-label">Password</label><label
                                        class="text-danger">*</label>
                                    <input type="password" name="password" class="form-control" id="password"
                                        placeholder=" enter password">
                                </div>
                            </div>


                            <button type="submit" class="btn btn-orange">Add User</button>
                          <a href="{{ route('admin.user') }}" class="btn btn-orange">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
