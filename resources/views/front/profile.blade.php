<main>
    <section class="profile_section">
        <div class="container">
            <div class="profile-content-main">
                <div class="profile-left">
                    <div class="profile-content">
                        <div class="profile-img">
                            <img src="{{ asset('assets/front/img/demo_profile.jpg') }}" height="100%" width="100%"
                                alt="">
                        </div>
                        <div class="profile-name">
                            <h4>{{ $user_profile->first_name . ' ' . $user_profile->last_name }}</h4>
                            <p> Member</p>
                        </div>
                    </div>
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <button class="nav-link btn profile-btn @if (request()->get('tab') == 'profile' || !request()->get('tab')) active @endif"
                            id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button"
                            role="tab" aria-controls="v-pills-home" aria-selected="true"><i
                                class="bi bi-person"></i>
                            Profile</button>
                        <button class="nav-link btn profile-btn @if (request()->get('tab') == 'downloads') active @endif"
                            id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile"
                            type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false"><i
                                class="fa-solid fa-download"></i> Downloads</button>

                        <button class="nav-link btn profile-btn @if (request()->get('tab') == 'wishlist') active @endif"
                            id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-messages"
                            type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false"><i
                                class="bi bi-heart"></i> Wishlist</button>

                        <button class="nav-link btn profile-btn @if (request()->get('tab') == 'settings') active @endif"
                            id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-settings"
                            type="button" role="tab">
                            <i class="bi bi-gear"></i> Settings
                        </button>
                        <!-- <button class="nav-link btn profile-btn @if (request()->get('tab') == 'settings') active @endif"
                         id="v-pills-settings-tab" data-bs-toggle="pill"
                            data-bs-target="#v-pills-settings"
                            type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false"><i
                                class="bi bi-gear"></i> Settings</button> -->
                    </div>

                </div>
            </div>
            <div class="tab-content profile-right" id="v-pills-tabContent">
                <div class="tab-pane fade @if (request()->get('tab') === 'profile' || empty(request()->get('tab'))) show active @endif" id="v-pills-home"
                    role="tabpanel" aria-labelledby="v-pills-home-tab" tabindex="0">
                    <div class="profile-manage ">
                        <div class="profile-manage-header">
                            <div class="profile-manage-heading">
                                <h3>Profile Details</h3>
                                <p>Manage your personal information and preferences.</p>
                            </div>
                            <button type="button" class="btn profile-heading-btn btn-all-dark btn-hover-dark"
                                data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                <i class="bi bi-pencil"></i>
                                Edit Profile
                            </button>
                        </div>
                        <div class="profile-manage-body">
                            <div class="profile-manage-left">
                                <div class="profile-manage-img">
                                    <img src="{{ asset('assets/front/img/demo_profile.jpg') }}" width="100%"
                                        height="100%" alt="">
                                    <!-- <div>
                                            <label for="myfile" class="mb-0" style="cursor: pointer;">
                                                <i class="bi bi-camera"></i>
                                            </label>
                                            <input type="file" id="myfile" name="myfile" multiple hidden><br><br>
                                        </div> -->
                                </div>
                                <div class="profile-manage-title">
                                    <h3>{{ $user_profile->first_name . ' ' . $user_profile->last_name }}</h3>
                                    <p>Member since
                                        {{ \Carbon\Carbon::parse($user_profile->created_at)->format('F Y') }}
                                    </p>
                                </div>
                            </div>
                            <div class="profile-manage-middle">
                                <div class="profile-mail profile-manage-text">
                                    <span>Email Address</span>
                                    <a href="mailto:alex.j@example.com">{{ $user_profile->email ?? '' }}</a>
                                </div>
                                <div class="profile-location profile-manage-text">
                                    <span>Location</span>
                                    <p>{{ $user_profile->address ? $user_profile->address : '-' }}</p>
                                </div>
                            </div>
                            <div class="profile-manage-right">
                                <div class="profile-number profile-manage-text">
                                    <span>Phone Number</span>
                                    <a
                                        href="tel:+1 (555) 000-1234">{{ $user_profile->phone ? $user_profile->phone : '-' }}</a>
                                </div>
                                <div class="profile-language profile-manage-text">
                                    <span>Language</span>
                                    <p>English</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if (!empty($purchasePlan))
                        <div class="subscription-plan">
                            <div class="subscription-left">
                                <div class="subscription-plan-header">
                                    <span class="section-badge" style="padding: 3px 14px;">Subscription</span>
                                    <!-- <span class="plan"><i class="fa-solid fa-circle" style="font-size: 5px;"></i>
                                                                                                    Active</span> -->
                                </div>
                                <div class="subscription-title-price">
                                    <div class="profile-subscription-title">
                                        <h3>{{ $purchasePlan->subscription->name }}</h3>
                                        <p class="text-secondary">{{ $purchasePlan->subscription->total_clips }} HD
                                            clips
                                            per
                                            {{ $purchasePlan->subscription->duration_type }}
                                        </p>
                                    </div>
                                    <!-- <p>{{ $purchasePlan->subscription->title }}</p> -->
                                    <h2><span class="yellow">$</span>{{ intval($purchasePlan->subscription->price) }}
                                        <span class="gray"> /
                                            {{ $purchasePlan->subscription->duration_type }}</span>
                                    </h2>
                                </div>
                                <div class="divider"></div>
                                <div class="renewal-info">
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                        <circle cx="7" cy="7" r="6" stroke="#ccc"
                                            stroke-width="1.2"></circle>
                                        <path d="M7 4v3.5l2 1.2" stroke="#aaa" stroke-width="1.2"
                                            stroke-linecap="round"></path>
                                    </svg>
                                    Plan valid till <strong>{{ $renewDate->format('F d, Y') }}</strong>

                                    <!-- Renews on <strong>&nbsp;July 12, 2025&nbsp;</strong> · Billed monthly -->
                                </div>
                            </div>
                            <!-- <div class="subscription-right">
                                                                                                    <div class="features-title">What's included</div>
                                                                                                    <ul class="features">
                                                                                                        <li class="feature-item">
                                                                                                            <span class="check-icon">
                                                                                                                <svg width="10" height="10" viewBox="0 0 10 10" fill="none">
                                                                                                                    <path d="M2 5l2.5 2.5L8 3" stroke="#ff8000" stroke-width="1.6"
                                                                                                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                                                                                                </svg>
                                                                                                            </span>
                                                                                                            Unlimited projects &amp; workspaces
                                                                                                        </li>
                                                                                                        <li class="feature-item">
                                                                                                            <span class="check-icon">
                                                                                                                <svg width="10" height="10" viewBox="0 0 10 10" fill="none">
                                                                                                                    <path d="M2 5l2.5 2.5L8 3" stroke="#ff8000" stroke-width="1.6"
                                                                                                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                                                                                                </svg>
                                                                                                            </span>
                                                                                                            Priority 24/7 customer support
                                                                                                        </li>
                                                                                                        <li class="feature-item">
                                                                                                            <span class="check-icon">
                                                                                                                <svg width="10" height="10" viewBox="0 0 10 10" fill="none">
                                                                                                                    <path d="M2 5l2.5 2.5L8 3" stroke="#ff8000" stroke-width="1.6"
                                                                                                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                                                                                                </svg>
                                                                                                            </span>
                                                                                                            Advanced analytics &amp; reports
                                                                                                        </li>
                                                                                                        <li class="feature-item">
                                                                                                            <span class="check-icon">
                                                                                                                <svg width="10" height="10" viewBox="0 0 10 10" fill="none">
                                                                                                                    <path d="M2 5l2.5 2.5L8 3" stroke="#ff8000" stroke-width="1.6"
                                                                                                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                                                                                                </svg>
                                                                                                            </span>
                                                                                                            100 GB secure cloud storage
                                                                                                        </li>
                                                                                                        <li class="feature-item">
                                                                                                            <span class="check-icon">
                                                                                                                <svg width="10" height="10" viewBox="0 0 10 10" fill="none">
                                                                                                                    <path d="M2 5l2.5 2.5L8 3" stroke="#ff8000" stroke-width="1.6"
                                                                                                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                                                                                                </svg>
                                                                                                            </span>
                                                                                                            API access &amp; integrations
                                                                                                        </li>
                                                                                                    </ul>
                                                                                                    </div> -->
                        </div>
                    @endif
                </div>
                <div class="tab-pane fade profile-order @if (request()->get('tab') === 'downloads') show active @endif"
                    id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab" tabindex="0">
                    @if ($order_data->isNotEmpty())
                        <div class="heading">
                            <h2>Recent Orders

                            </h2>
                        </div>
                        <div class="">
                            @foreach ($order_data as $order)
                                <div class="batch-content">

                                    <div class="batch-content-detail">

                                        <div class="batch-content-create">
                                            <p class="batchid">Order ID : {{ $order->order_number }}</p>
                                            <p class="batchcreated">
                                                Date :
                                                {{ \Carbon\Carbon::parse($order->created_at)->format('M d, Y') }}
                                            </p>
                                            <p class="batchid">Total Amount : ${{ $order->total_amount }}</p>
                                            <p class="batchid">Status : {{ $order->order_status }}</p>
                                        </div>

                                        <div class="more-detail">
                                            <button class="btn more-detail-btn" type="button">
                                                <i class="fa-solid fa-angle-down"></i> More Detail
                                            </button>
                                        </div>
                                    </div>

                                    <!-- DETAILS TABLE -->
                                    <div class="batch-content-table-details d-none">
                                        <div class="table-scroll">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Product</th>
                                                        <th>Product Type</th>
                                                        <th>Product Name</th>
                                                        <th>Price</th>
                                                        <!-- <th>Status</th> -->
                                                    </tr>
                                                </thead>

                                        </div>
                                        <!-- Modal -->
                                        <div class="modal fade profile-modal " id="staticBackdrop"
                                            data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                            aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog  modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title" id="staticBackdropLabel">Edit Profile
                                                        </h1>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('front.update_profile') }}" method="POST"
                                                        name="profile_form" id="profile_form">
                                                        @csrf
                                                        <div class="modal-body p-0">
                                                            <div class="modal-inp-label">
                                                                <input type="hidden" name="user_id"
                                                                    value="{{ encrypt($user_profile->id) }}">
                                                                <label>First Name</label>
                                                                <input type="text" name="first_name"
                                                                    id="first_name" class="form-control"
                                                                    value="{{ $user_profile->first_name }}"
                                                                    placeholder="Enter Your First Name">
                                                            </div>
                                                            <div class="modal-inp-label">
                                                                <label>Last Name</label>
                                                                <input type="text" name="last_name" id="last_name"
                                                                    class="form-control"
                                                                    value="{{ $user_profile->last_name }}"
                                                                    placeholder="Enter Your Last Name">
                                                            </div>
                                                            <div class="modal-inp-label">
                                                                <label>Email</label>
                                                                <input type="email" name="email" id="email"
                                                                    class="form-control" placeholder="you@example.com"
                                                                    value="{{ $user_profile->email }}">
                                                            </div>

                                                            <div>
                                                                <label>Phone No</label>

                                                                <div class="input-group  phone-input">
                                                                    <input type="tel" id="phone"
                                                                        name="phone_number" class="form-control"
                                                                        placeholder="Enter your phone number"
                                                                        value="{{ $user_profile->phone ?? '' }}"
                                                                        oninput="this.value = this.value.replace(/[^0-9-]/g,'')">
                                                                </div>

                                                                <!-- Hidden field that stores full phone -->
                                                                <input type="hidden" name="phone" id="full_phone"
                                                                    value="{{ $user_profile->phone ?? '' }}">

                                                            </div>
                                                            <!-- <div class="modal-inp-label">
                                <label>Phone No</label>
                                <input type="tel" name="phone" id="phone" class="form-control"
                                    placeholder="Enter Phone no" value="{{ $user_profile->phone ?? '' }}">
                            </div> -->
                                                            <div class="modal-inp-label">
                                                                <label>Address</label>
                                                                <textarea name="address" class="form-control">{{ $user_profile->address ?? '' }}</textarea>
                                                            </div>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button"
                                                                class="btn btn-all-dark btn-hover-dark"
                                                                data-bs-dismiss="modal">Cancle</button>
                                                            <button type="submit"
                                                                class="btn btn-orange">Submit</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal fade password-modal " id="password_change"
                                            data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                            aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog  modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title" id="staticBackdropLabel">Change
                                                            Password</h1>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('front.update_password') }}"
                                                        method="POST" name="password_form" id="password_form">
                                                        @csrf
                                                        <div class="modal-body p-0">
                                                            <div class="modal-inp-label">
                                                                <input type="hidden" name="id"
                                                                    value="{{ $user_profile->id ?? '' }}">
                                                                <label>Current Password</label>
                                                                <input type="password" name="current_password"
                                                                    id="current_password" class="form-control"
                                                                    placeholder="Enter Current Password">
                                                            </div>
                                                            <div class="modal-inp-label">
                                                                <label>New Password</label>
                                                                <input type="password" name="new_password"
                                                                    id="new_password" class="form-control"
                                                                    placeholder="Enter New Password">
                                                            </div>
                                                            <div class="modal-inp-label">
                                                                <label>Confirm Password</label>
                                                                <input type="password" name="confirm_password"
                                                                    id="confirm_password" class="form-control"
                                                                    placeholder="Enter Confirm Password">
                                                            </div>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button"
                                                                class="btn btn-all-dark btn-hover-dark"
                                                                data-bs-dismiss="modal">Cancle</button>
                                                            <button type="submit"
                                                                class="btn btn-orange">Submit</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade profile-modal " id="settinginfo"
                                            data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                            aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog  modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title" id="staticBackdropLabel">Edit Profile
                                                        </h1>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="">
                                                        <div class="modal-body p-0">
                                                            <div class="modal-inp-label">
                                                                <label> Name</label>
                                                                <input type="text" name="username"
                                                                    class="form-control"
                                                                    placeholder="Enter Your Name">
                                                            </div>
                                                            <div class="modal-inp-label">
                                                                <label>Email</label>
                                                                <input type="email" name="email"
                                                                    class="form-control"
                                                                    placeholder="you@example.com">
                                                            </div>
                                                            <div class="modal-inp-label">
                                                                <label>Phone number</label>
                                                                <input type="text" name="number"
                                                                    class="form-control" placeholder="1234567890">
                                                            </div>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button"
                                                                class="btn btn-all-dark btn-hover-dark"
                                                                data-bs-dismiss="modal">Cancle</button>
                                                            <button type="button"
                                                                class="btn btn-orange">Submit</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
    </section>
</main>
