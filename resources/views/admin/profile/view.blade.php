<div class="body-wrapper-inner">
    <div class="container-fluid">
        <div class="add-new-customer-wrp ">
            <h3 class="p-2">Update Profile</h3>
            <div class="profileContainer card">

                <div class="card-body">

                    <form method="post" action="{{ route('admin.update_profile') }}" name="profile_form"
                        id="profile_form" class="">
                        @csrf
                        <label style="margin-bottom:20px;"><b>Role:{{ $user->name }}</b></label>
                        <!-- <div class="row"> -->
                        <input type="hidden" name="id" value="{{ $user->id ?? '' }}">
                        <input type="hidden" name="user_id" value="{{ encrypt($user->id)  }}">
                        <div class="row">
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
                                <div class="form-group input-section">
                                    <label for="name">First Name</label>
                                    <input type="text" name="first_name" class="form-control" id="first_name"
                                        placeholder="Enter User Name" value="{{ $user->first_name ?? '' }}">
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
                                <div class="form-group input-section">
                                    <label for="name">Last Name</label>
                                    <input type="text" name="last_name" class="form-control" id="last_name"
                                        placeholder="Enter User Name" value="{{ $user->last_name ?? '' }}">
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
                                <div class="form-group input-section">
                                    <label for="email">Email</label>
                                    <input type="text" name="email" class="form-control"
                                        value="{{ $user->email ?? '' }}" id="email"
                                        placeholder="Enter E-mail Address">
                                </div>
                            </div>

                            <!-- <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
                    <div class="form-group input-section">
                        <label for="mobile">Mobile</label> 
                        <input type="text" name="mobile" class="form-control" value="{{ $user->mobile ?? '' }}" id="mobile"
                            placeholder="Enter Mobile Number">
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
                    <div class="form-group input-section">
                        <label for="gender">Gender</label>
                        <select name="gender" id="gender" class="form-control">
                            <option value="Male" name="male" @if($user->gender == 'Male') selected @endif>Male</option>
                            <option value="Female" name="female" @if($user->gender == 'Female') selected @endif>Female
                            </option>
                        </select>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
                    <div class="form-group input-section">
                        <label for="pin"> Pin </label> 
                        <input type="number" name="pin" id="pin" class="form-control" placeholder="Enter Pin"
                            inputmode="numeric" value="{{$user->pin ?? ''}}">

                    </div>
                </div> -->
                        </div>
                        <button type="submit" id="submit_btn" class="save btn cmn-btn btn-orange mt-3"
                            style="">Save</button>
                    </form>
                </div>
            </div>



            <div class="add-new-customer-wrp">
                <h3 class="p-2">Update Password</h3>
                <div class="card">
                    <div class="card-body">

                        <form method="post" action="{{ route('admin.update_password') }}" name="password_form"
                            id="password_form" class="">
                            @csrf

                            <!-- <div class="row"> -->
                            <input type="hidden" name="id" value="{{ $user->id ?? '' }}">
                            <input type="hidden" name="outlet_id" value="{{ $user->outlet_id ?? '' }}">
                            <div class="row">
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
                                    <div class="form-group input-section">
                                        <label for="name">Current Password</label>
                                        <input type="password" name="current_password" class="form-control"
                                            id="current_password" placeholder="Enter current password">
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
                                    <div class="form-group input-section">
                                        <label for="name">New Password</label>
                                        <input type="password" name="new_password" class="form-control"
                                            id="new_password" placeholder="Enter new password">
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
                                    <div class="form-group input-section">
                                        <label for="name">Confirm Password</label>
                                        <input type="password" name="confirm_password" class="form-control"
                                            id="confirm_password" placeholder="Enter confirm password">
                                    </div>
                                </div>
                            </div>



                            <button type="submit" id="submit_btn" class="save cmn-btn btn-orange btn mt-3"
                                style="">Update</button>
                    </div>
                </div>