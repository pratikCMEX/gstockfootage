<style>
    .add-new-customer-wrp h3{
        margin-bottom: 20px !important;
    }
</style>



<div class="body-wrapper-inner">
    <div class="container-fluid">
        <div class="add-new-customer-wrp ">
            <h3 class="p-2">Update Profile</h3>
            <div class="profileContainer card">

                <div class="card-body">

                    <form method="post" action="{{ route('affiliate.update_profile') }}" name="profile_form"
                        id="profile_form" class="">
                        @csrf

                        <!-- <div class="row"> -->
                        <input type="hidden" name="id" value="{{ $affiliateUser->id ?? '' }}">
                        <input type="hidden" name="affiliateUser_id" value="{{ encrypt($affiliateUser->id)  }}">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-3">
                                <div class="form-group input-section">
                                    <label class="form-label" for="name">First Name</label><label
                                        for="" class="text-danger">*</label>
                                    <input type="text" name="first_name" class="form-control" id="first_name"
                                        placeholder="Enter Affiliate User First Name"
                                        value="{{ $affiliateUser->first_name ?? '' }}">
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-3">
                                <div class="form-group input-section">
                                    <label class="form-label" for="name">Last Name</label><label
                                        for="" class="text-danger">*</label>
                                    <input type="text" name="last_name" class="form-control" id="last_name"
                                        placeholder="Enter Affiliate User Last Name"
                                        value="{{ $affiliateUser->last_name ?? '' }}">
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-3">
                                <div class="form-group input-section">
                                    <label class="form-label" for="email">Email</label><label for="" class="text-danger">*</label>
                                    <input type="text" name="email" class="form-control"
                                        value="{{ $affiliateUser->email ?? '' }}" id="email"
                                        placeholder="Enter E-mail Address">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-3">
                                <label class="form-label">Phone No</label>
                                <div class="input-group phone-input">
                                    <input type="tel" id="phone" name="phone_number" class="form-control"
                                        placeholder="Enter your phone number" value="{{ $affiliateUser->phone ?? '' }}"
                                        oninput="this.value = this.value.replace(/[^0-9-]/g,'')">
                                </div>

                                {{-- Hidden fields --}}
                                <input type="hidden" name="phone" id="full_phone"
                                    value="{{ $affiliateUser->phone ?? '' }}">
                                <input type="hidden" name="country_code" id="country_code"
                                    value="{{ $affiliateUser->country_code ?? '' }}">
                                     <label id="phone-error" class="text-danger mb-2 mt-2" for="phone"></label>
                            </div>
                           
                            <div class="col-12 mb-3">
                                <div class="form-group input-section">
                                    <label class="form-label" for="email">Address</label>
                                    <textarea name="address" rows="4"
                                        class="form-control w-50">{{ $affiliateUser->address ?? '' }}</textarea>

                                </div>
                            </div>

                            <!-- <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
                    <div class="form-group input-section">
                        <label for="mobile">Mobile</label> 
                        <input type="text" name="mobile" class="form-control" value="{{ $affiliateUser->mobile ?? '' }}" id="mobile"
                            placeholder="Enter Mobile Number">
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
                    <div class="form-group input-section">
                        <label for="gender">Gender</label>
                        <select name="gender" id="gender" class="form-control">
                            <option value="Male" name="male" @if($affiliateUser->gender == 'Male') selected @endif>Male</option>
                            <option value="Female" name="female" @if($affiliateUser->gender == 'Female') selected @endif>Female
                            </option>
                        </select>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
                    <div class="form-group input-section">
                        <label for="pin"> Pin </label> 
                        <input type="number" name="pin" id="pin" class="form-control" placeholder="Enter Pin"
                            inputmode="numeric" value="{{$affiliateUser->pin ?? ''}}">

                    </div>
                </div> -->
                        </div>
                        <button type="submit" id="submit_btn" class="save btn cmn-btn btn-orange mt-3"
                            style="">Update</button>
                    </form>
                </div>
            </div>



             <div class="add-new-customer-wrp">
                <h3 class="p-2">Update Password</h3>
                <div class="card">
                    <div class="card-body">

                        <form method="post" action="{{ route('affiliate.update_password') }}" name="password_form"
                            id="password_form" class="">
                            @csrf

                            
                            <input type="hidden" name="id" value="{{ $affiliateUser->id ?? '' }}">
                            <input type="hidden" name="outlet_id" value="{{ $affiliateUser->outlet_id ?? '' }}">
                            <div class="row">
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
                                    <div class="form-group input-section">
                                        <label for="name" class="form-label">Current Password</label><label for="" class="text-danger">*</label>
                                        <input type="password" name="current_password" class="form-control"
                                            id="current_password" placeholder="Enter current password">
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
                                    <div class="form-group input-section">
                                        <label for="name" class="form-label">New Password</label><label for="" class="text-danger">*</label>
                                        <input type="password" name="new_password" class="form-control"
                                            id="new_password" placeholder="Enter new password">
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
                                    <div class="form-group input-section">
                                        <label for="name" class="form-label">Confirm Password</label><label for="" class="text-danger">*</label>
                                        <input type="password" name="confirm_password" class="form-control"
                                            id="confirm_password" placeholder="Enter confirm password">
                                    </div>
                                </div>
                            </div>



                            <button type="submit" id="submit_btn" class="save cmn-btn btn-orange btn mt-3"
                                style="">Update</button>
                    </div>
                </div>
            </div> 