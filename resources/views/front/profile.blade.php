<main>
    <section class="profile_section">
        <div class="container">
            <div class="profile-content-main">
                <div class="profile-left">
                    <div class="profile-content">
                        <div class="profile-img">
                            <img src="https://images.unsplash.com/photo-1772442199087-f03254e07bd0?q=80&w=735&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                                height="100%" width="100%" alt="">
                        </div>
                        <div class="profile-name">
                            <h4>{{ $user_profile->first_name . ' ' . $user_profile->last_name }}</h4>
                            <p> Member</p>
                        </div>
                    </div>
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <button class="nav-link btn profile-btn active" id="v-pills-home-tab" data-bs-toggle="pill"
                            data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home"
                            aria-selected="true"><i class="bi bi-person"></i> Profile</button>
                        <button class="nav-link btn profile-btn" id="v-pills-profile-tab" data-bs-toggle="pill"
                            data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile"
                            aria-selected="false"><i class="bi bi-bag"></i> Order</button>

                        <button class="nav-link btn profile-btn" id="v-pills-messages-tab" data-bs-toggle="pill"
                            data-bs-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages"
                            aria-selected="false"><i class="bi bi-heart"></i> Wishlist</button>
                        <button class="nav-link btn profile-btn" id="v-pills-settings-tab" data-bs-toggle="pill"
                            data-bs-target="#v-pills-settings" type="button" role="tab" aria-controls="v-pills-settings"
                            aria-selected="false"><i class="bi bi-gear"></i> Settings</button>
                    </div>
                </div>
                <div class="tab-content profile-right" id="v-pills-tabContent">
                    <div class="tab-pane fade show active profile-manage" id="v-pills-home" role="tabpanel"
                        aria-labelledby="v-pills-home-tab" tabindex="0">
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
                                    <img src="https://images.unsplash.com/photo-1772442199087-f03254e07bd0?q=80&w=735&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                                        width="100%" height="100%" alt="">
                                    <div>
                                        <label for="myfile" class="mb-0" style="cursor: pointer;">
                                            <i class="bi bi-camera"></i>
                                        </label>
                                        <input type="file" id="myfile" name="myfile" multiple hidden><br><br>
                                    </div>
                                </div>
                                <div class="profile-manage-title">
                                    <h3>{{ $user_profile->first_name . ' ' . $user_profile->last_name }}</h3>
                                    <p>Member since January 2023</p>
                                </div>
                            </div>
                            <div class="profile-manage-middle">
                                <div class="profile-mail profile-manage-text">
                                    <span>Email Address</span>
                                    <a href="mailto:alex.j@example.com">{{ $user_profile->email }}</a>
                                </div>
                                <div class="profile-location profile-manage-text">
                                    <span>Location</span>
                                    <p>San Francisco, CA</p>
                                </div>
                            </div>
                            <div class="profile-manage-right">
                                <div class="profile-number profile-manage-text">
                                    <span>Phone Number</span>
                                    <a href="tel:+1 (555) 000-1234">+1 (555) 000-1234</a>
                                </div>
                                <div class="profile-language profile-manage-text">
                                    <span>Language</span>
                                    <p>English</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade profile-order" id="v-pills-profile" role="tabpanel"
                        aria-labelledby="v-pills-profile-tab" tabindex="0">
                        <div class="heading">
                            <h2>Recent Order</h2>
                        </div>
                        <div class="order-content">
                            <div class="order-detail-main">
                                <div class="order-img">
                                    <img src="https://images.unsplash.com/photo-1772752021285-27e336543d01?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                                        alt="">
                                </div>
                                <div class="order-detail">
                                    <div class="order-title">
                                        <h4>Images Name</h4>
                                        <span><i class="bi bi-calendar"></i> Oct 24 , 2025</span>
                                    </div>
                                    <h4 class="order-price">$199.00</h4>
                                </div>
                            </div>
                            <div class="order-detail-main">
                                <div class="order-img">
                                    <img src="https://images.unsplash.com/photo-1772903813434-1ef535363867?q=80&w=1025&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                                        alt="">
                                </div>
                                <div class="order-detail">
                                    <div class="order-title">
                                        <h4>Images Name</h4>
                                        <span><i class="bi bi-calendar"></i> June 4 , 2025</span>
                                    </div>
                                    <div class="order-price">$145.00</div>
                                </div>
                            </div>
                            <div class="order-detail-main">
                                <div class="order-img">
                                    <img src="https://images.unsplash.com/photo-1772767511365-c7a5036bd55c?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                                        alt="">
                                </div>
                                <div class="order-detail">
                                    <div class="order-title">
                                        <h4>Images Name</h4>
                                        <span><i class="bi bi-calendar"></i> Feb 8 , 2025</span>
                                    </div>
                                    <div class="order-price">$89.99</div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="tab-pane fade profile-wishlist" id="v-pills-messages" role="tabpanel"
                        aria-labelledby="v-pills-messages-tab" tabindex="0">
                        <div class="wishlist-content">
                            <div class="wishlist-heading">
                                <div class="heading">
                                    <h2 class="mb-0">Wishlist</h2>
                                </div>
                                <p class="item-count">3 items</p>
                            </div>
                            <div class="wishlist-product-content">
                                <div class="row row-gap-4">
                                    <div class="col-lg-4 col-md-6 col-xs-12">
                                        <div class="wishlist-product-detail">
                                            <div class="product-card">
                                                <div class="product-img-div">
                                                    <a href="product-detail.html">
                                                        <img src="https://images.unsplash.com/photo-1772752021241-2d922cadbab1?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                                                            class="product-img" alt="">
                                                    </a>
                                                    <div class="remove-product"><i class="bi bi-x"></i></div>
                                                </div>
                                                <div class="p-3">
                                                    <a href="product-detail.html">
                                                        <h6 class="popular-detail-title">Art & Craft</h6>
                                                    </a>
                                                    <div class="price-btn">
                                                        <span class="price mb-0">$149</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-xs-12">
                                        <div class="wishlist-product-detail">
                                            <div class="product-card">
                                                <div class="product-img-div">
                                                    <a href="product-detail.html">
                                                        <img src="https://images.unsplash.com/photo-1772752021241-2d922cadbab1?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                                                            class="product-img" alt="">
                                                    </a>
                                                    <div class="remove-product"><i class="bi bi-x"></i></div>
                                                </div>
                                                <div class="p-3">
                                                    <a href="product-detail.html">
                                                        <h6 class="popular-detail-title">Art & Craft</h6>
                                                    </a>
                                                    <div class="price-btn">
                                                        <span class="price mb-0">$149</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-xs-12">
                                        <div class="product-card">
                                            <div class="product-img-div">
                                                <a href="product-detail.html">
                                                    <img src="https://images.unsplash.com/photo-1772752021241-2d922cadbab1?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                                                        class="product-img" alt="">
                                                </a>
                                                <div class="remove-product"><i class="bi bi-x"></i></div>
                                            </div>
                                            <div class="p-3">
                                                <a href="product-detail.html">
                                                    <h6 class="popular-detail-title">Art & Craft</h6>
                                                </a>
                                                <div class="price-btn">
                                                    <span class="price mb-0">$149</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade profile-setting" id="v-pills-settings" role="tabpanel"
                        aria-labelledby="v-pills-settings-tab" tabindex="0">
                        <div class="heading">
                            <h2>Settings</h2>
                        </div>
                        <div class="setting-content">
                            <div class="acc-info setting-detail">
                                <div class="acc-info-heading">
                                    <h4><span><i class="bi bi-person"></i></span>Account Information</h4>
                                    <button type="button" class="btn btn-orange" data-bs-toggle="modal"
                                        data-bs-target="#staticBackdrop">
                                        Edit
                                    </button>
                                </div>
                                <div class="acc-info-body">
                                    <div>
                                        <span>Full Name</span>
                                        <p>{{  $user_profile->first_name . ' ' . $user_profile->last_name }}</p>
                                    </div>
                                    <div>
                                        <span>Email Address</span>
                                        <p>{{ $user_profile->email }}</p>
                                    </div>
                                    <div>
                                        <span>Phone</span>
                                        <p>+1 (555) 000-1234</p>
                                    </div>
                                </div>
                            </div>
                            <div class="security setting-detail">
                                <div class="acc-info-heading">
                                    <h4><span><i class="bi bi-shield-lock"></i></span>Security</h4>
                                </div>
                                <div class="security-password security-detail">
                                    <div class="pass-title">
                                        <h4>Password</h4>
                                        <p>Last changed 3 months ago</p>
                                    </div>
                                    <button type="button" class="btn profile-heading-btn btn-all-dark btn-hover-dark"
                                        data-bs-toggle="modal" data-bs-target="#password_change">
                                        <i class="bi bi-pencil"></i>
                                        Change
                                    </button>
                                    <!-- <button type="button"
                                        class="btn btn-all-dark btn-hover-dark pass-btn">Change</button> -->
                                </div>
                                <div class="security-two-factor security-detail">
                                    <div class="pass-title">
                                        <h4>Two-factor Auth</h4>
                                        <p>Protects your account with extra security</p>
                                    </div>
                                    <button type="button" class="btn btn-orange">Enable</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- Modal -->
        <div class="modal fade profile-modal " id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog  modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title" id="staticBackdropLabel">Edit Profile</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('front.update_profile') }}" method="POST" name="profile_form"
                        id="profile_form">
                        @csrf
                        <div class="modal-body p-0">
                            <div class="modal-inp-label">
                                <input type="hidden" name="user_id" value="{{ encrypt($user_profile->id)  }}">
                                <label>First Name</label>
                                <input type="text" name="first_name" id="first_name" class="form-control"
                                    value="{{ $user_profile->first_name }}" placeholder="Enter Your First Name">
                            </div>
                            <div class="modal-inp-label">
                                <label>Last Name</label>
                                <input type="text" name="last_name" id="last_name" class="form-control"
                                    value="{{ $user_profile->last_name }}" placeholder="Enter Your Last Name">
                            </div>
                            <div class="modal-inp-label">
                                <label>Email</label>
                                <input type="email" name="email" id="email" class="form-control"
                                    placeholder="you@example.com" value="{{ $user_profile->email }}">
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-all-dark btn-hover-dark"
                                data-bs-dismiss="modal">Cancle</button>
                            <button type="submit" class="btn btn-orange">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade password-modal " id="password_change" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog  modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title" id="staticBackdropLabel">Change Password</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('front.update_password') }}" method="POST" name="password_form"
                        id="password_form">
                        @csrf
                        <div class="modal-body p-0">
                            <div class="modal-inp-label">
                                <input type="hidden" name="id" value="{{$user_profile->id ?? '' }}">
                                <label>Current Password</label>
                                <input type="text" name="current_password" id="current_password" class="form-control"
                                    placeholder="Enter Your First Name">
                            </div>
                            <div class="modal-inp-label">
                                <label>New Password</label>
                                <input type="text" name="new_password" id="new_password" class="form-control"
                                    placeholder="Enter Your Last Name">
                            </div>
                            <div class="modal-inp-label">
                                <label>Confirm Password</label>
                                <input type="text" name="confirm_password" id="confirm_password" class="form-control"
                                    placeholder="you@example.com">
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-all-dark btn-hover-dark"
                                data-bs-dismiss="modal">Cancle</button>
                            <button type="submit" class="btn btn-orange">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade profile-modal " id="settinginfo" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog  modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title" id="staticBackdropLabel">Edit Profile</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="">
                        <div class="modal-body p-0">
                            <div class="modal-inp-label">
                                <label> Name</label>
                                <input type="text" name="username" class="form-control" placeholder="Enter Your Name">
                            </div>
                            <div class="modal-inp-label">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" placeholder="you@example.com">
                            </div>
                            <div class="modal-inp-label">
                                <label>Phone number</label>
                                <input type="text" name="number" class="form-control" placeholder="1234567890">
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-all-dark btn-hover-dark"
                                data-bs-dismiss="modal">Cancle</button>
                            <button type="button" class="btn btn-orange">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>