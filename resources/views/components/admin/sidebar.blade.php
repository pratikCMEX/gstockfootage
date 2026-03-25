<aside class="left-sidebar">
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="{{ route('admin.dashboard') }}" class="text-nowrap logo-img">
                {{-- <img src="{{ asset('assets/admin/images/logos/logo.svg') }}" alt="" /> --}}
                <img src="{{ asset('assets/admin/images/logos/gsstocklogo.png') }}" alt="" height="110"
                    width="220">
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-6"></i>
            </div>
        </div>
        <nav class="sidebar-nav scroll-sidebar mt-4" data-simplebar="">
            <ul id="sidebarnav">

                @auth('affiliate')
                    <!--  ONLY DASHBOARD -->
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ Request::segment(2) == 'dashboard' ? 'active  ' : '' }} side-item"
                            href="{{ route('admin.dashboard') }}" aria-expanded="false">
                            <i class="ti ti-home"></i>
                            <span class="hide-menu">Dashboard</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ Request::segment(2) == 'referrals' ? 'active  ' : '' }} side-item"
                            href="{{ route('affiliate.referrals') }}" aria-expanded="false">
                            <i class="fa-solid fa-users"></i>
                            <span class="hide-menu">Refarral Users</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ Request::segment(2) == 'commission_history' ? 'active  ' : '' }} side-item"
                            href="{{ route('affiliate.commission_history') }}" aria-expanded="false">
                            🕘
                            <span class="hide-menu">Commision History</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ Request::segment(2) == 'pending_payments' ? 'active  ' : '' }} side-item"
                            href="{{ route('affiliate.pending_payments') }}" aria-expanded="false">
                            <i class="fa fa-hourglass-half"></i>
                            <span class="hide-menu">Pending Payments List</span>
                        </a>
                    </li>
                @else
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ Request::segment(2) == 'dashboard' ? 'active  ' : '' }} side-item"
                            href="{{ route('admin.dashboard') }}" aria-expanded="false">
                            <i class="ti ti-home"></i>
                            <span class="hide-menu">Dashboard</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ in_array(Request::segment(2), ['banner']) ? 'active  ' : '' }}side-item"
                            href="{{ route('admin.banner') }}" aria-expanded="false">
                            <!-- <i class="ti ti-layout-grid"></i> -->
                            <i class="fa-solid fa-image"></i>
                            <span class="hide-menu">Login Banner</span>
                        </a>
                    </li>
                    <li class="sidebar-item d-none">
                        <a class="sidebar-link {{ in_array(Request::segment(2), ['affiliate-setting']) ? 'active  ' : '' }}side-item"
                            href="{{ route('admin.affiliate.setting') }}" aria-expanded="false">
                            <!-- <i class="ti ti-layout-grid"></i> -->
                            <i class="fa-solid fa-table-cells-large"></i>
                            <span class="hide-menu">Affiliate Settings</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ in_array(Request::segment(2), ['affiliates']) ? 'active  ' : '' }}side-item"
                            href="{{ route('admin.affiliates.list') }}" aria-expanded="false">
                            <!-- <i class="ti ti-layout-grid"></i> -->
                            <i class="fa-solid fa-users"></i>
                            <span class="hide-menu">Affiliate User</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ in_array(Request::segment(2), ['category', 'add_category', 'edit_category']) ? 'active  ' : '' }}side-item"
                            href="{{ route('admin.category') }}" aria-expanded="false">
                            <!-- <i class="ti ti-layout-grid"></i> -->
                            <i class="fa-solid fa-table-cells-large"></i>
                            <span class="hide-menu">Categories</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ in_array(Request::segment(2), ['sub_category', 'add_sub_category', 'edit_sub_category']) ? 'active  ' : '' }} side-item"
                            href="{{ route('admin.sub_category') }}" aria-expanded="false">
                            <!-- <i class="ti ti-layout-grid"></i> -->
                            <i class="fa-solid fa-table-list"></i>
                            <span class="hide-menu">Sub Categories</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ in_array(Request::segment(2), ['collection', 'add_collection', 'edit_collection']) ? 'active  ' : '' }} side-item"
                            href="{{ route('admin.collection') }}" aria-expanded="false">
                            <!-- <i class="ti ti-layout-grid"></i> -->
                            <i class="fa-solid fa-layer-group"></i>
                            <span class="hide-menu">Collection</span>
                        </a>
                    </li>
                    {{-- <li class="sidebar-item">
                        <a class="sidebar-link {{ in_array(Request::segment(2), ['image', 'add_image', 'edit_image']) ? 'active  ' : '' }} side-item"
                            href="{{ route('admin.image') }}" aria-expanded="false">
                            <!-- <i class="ti ti-cards"></i> -->
                            <i class="fa-solid fa-chalkboard-user"></i>
                            <span class="hide-menu">Image Manager</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ in_array(Request::segment(2), ['video', 'add_video', 'edit_video']) ? 'active  ' : '' }} side-item"
                            href="{{ route('admin.video') }}" aria-expanded="false">
                            <!-- <i class="ti ti-chart-donut-3"></i> -->
                            <i class="fa-solid fa-chalkboard-user"></i>
                            <span class="hide-menu">Video Manager</span>
                        </a>
                    </li> --}}
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ in_array(Request::segment(2), ['product', 'add_product', 'edit_product']) ? 'active  ' : '' }} side-item"
                            href="{{ route('admin.product') }}" aria-expanded="false">
                            <!-- <i class="ti ti-chart-donut-3"></i> -->
                            <i class="fa-brands fa-product-hunt"></i>
                            <span class="hide-menu">Product Manager</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link {{ in_array(Request::segment(2), ['user', 'add_user', 'edit_user']) ? 'active  ' : '' }} side-item"
                            href="{{ route('admin.user') }}" aria-expanded="false">
                            <i class="ti ti-user-circle"></i>
                            <span class="hide-menu">Users</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ in_array(Request::segment(2), ['license', 'add_license', 'edit_license']) ? 'active  ' : '' }} side-item"
                            href="{{ route('admin.license') }}" aria-expanded="false">
                            <i class="ti ti-shield-check "></i>
                            <span class="hide-menu">Licenses</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ in_array(Request::segment(2), ['subscriptions', 'add_subscription', 'edit_subscription']) ? 'active  ' : '' }} side-item"
                            href="{{ route('admin.subscriptions') }}" aria-expanded="false">
                            <i class="fa-solid fa-square-rss"></i>
                            <span class="hide-menu">Subscriptions </span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ in_array(Request::segment(2), ['user_subscriptions', 'add_user_subscription', 'edit_user_subscription']) ? 'active  ' : '' }} side-item"
                            href="{{ route('admin.user_subscriptions_report') }}" aria-expanded="false">
                            <i class="fa-solid fa-id-card"></i>
                            <span class="hide-menu">Users Subscriptions </span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ in_array(Request::segment(2), ['blog']) ? 'active  ' : '' }} side-item"
                            href="{{ route('admin.blog') }}" aria-expanded="false">
                            <i class="ti  ti-credit-card"></i>
                            <span class="hide-menu">Blogs </span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ in_array(Request::segment(2), ['contact_us']) ? 'active  ' : '' }} side-item"
                            href="{{ route('admin.contact_us') }}" aria-expanded="false">
                            <i class="ti ti-user-circle"></i>
                            <span class="hide-menu">Contact Us</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ in_array(Request::segment(2), ['about_us']) ? 'active  ' : '' }} side-item"
                            href="{{ route('admin.about_us') }}" aria-expanded="false">
                            <i class="fa-solid fa-circle-info"></i>
                            <span class="hide-menu">About Us</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ in_array(Request::segment(2), ['content']) ? 'active  ' : '' }} side-item"
                            href="{{ route('admin.content') }}" aria-expanded="false">
                            <i class="fa-brands fa-blogger"></i>
                            <span class="hide-menu">Content Master</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ in_array(Request::segment(2), ['batch', 'add_new_img']) ? 'active  ' : '' }} side-item"
                            href="{{ route('admin.batch') }}" aria-expanded="false">
                            <!-- <i class="ti ti-user-circle"></i> -->
                            <i class="fa-regular fa-clone"></i>
                            <span class="hide-menu">Batchs</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ in_array(Request::segment(2), ['order_history', 'order_detail']) ? 'active  ' : '' }} side-item"
                            href="{{ route('admin.order_history') }}" aria-expanded="false">
                            <!-- <i class="ti ti-user-circle"></i> -->
                            <i class="fa-solid fa-cart-arrow-down"></i>
                            <span class="hide-menu">Order History</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link justify-content-between has-arrow {{ in_array(Request::segment(2), ['most_sold_product_report', 'most_viewed_product_report', 'live_cart_report', 'user_wise_order_report']) ? 'active  btn-orange' : '' }} "
                            href="javascript:void(0)" aria-expanded="false">
                            <div class="d-flex align-items-center gap-3">
                                <span class="d-flex">
                                    <i class="fa fa-bar-chart"></i>
                                </span>
                                <span class="hide-menu">Reports</span>
                            </div>
                        </a>
                        <ul aria-expanded="false" class="collapse first-level">
                            <li class="sidebar-item">
                                <a class="sidebar-link justify-content-between {{ in_array(Request::segment(2), ['most_sold_product_report']) ? 'active ' : '' }} "
                                    href="{{ route('admin.most_sold_product_report') }}">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="round-16 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-circle"></i>
                                        </div>
                                        <span class="hide-menu">Most Sold Products</span>
                                    </div>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link justify-content-between {{ in_array(Request::segment(2), ['most_viewed_product_report']) ? 'active ' : '' }} "
                                    href="{{ route('admin.most_viewed_product_report') }}">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="round-16 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-circle"></i>
                                        </div>
                                        <span class="hide-menu">Most Viewed Product</span>
                                    </div>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link justify-content-between {{ in_array(Request::segment(2), ['live_cart_report']) ? 'active ' : '' }} "
                                    href="{{ route('admin.live_cart_report') }}">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="round-16 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-circle"></i>
                                        </div>
                                        <span class="hide-menu">Live Cart Report</span>
                                    </div>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link justify-content-between {{ in_array(Request::segment(2), ['user_wise_order_report']) ? 'active ' : '' }} "
                                    href="{{ route('admin.user_wise_order_report') }}">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="round-16 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-circle"></i>
                                        </div>
                                        <span class="hide-menu">User Wise Order Report</span>
                                    </div>
                                </a>
                            </li>
                            <!-- <li class="sidebar-item">
                                                                                            <a class="sidebar-link justify-content-between {{ in_array(Request::segment(2), ['social_links']) ? 'active ' : '' }} "
                                                                                                href="{{ route('admin.social_links') }}">
                                                                                                <div class="d-flex align-items-center gap-3">
                                                                                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                                                                                        <i class="ti ti-circle"></i>
                                                                                                    </div>
                                                                                                    <span class="hide-menu">Social Links</span>
                                                                                                </div>
                                                                                            </a>
                                                                                        </li> -->
                        </ul>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ in_array(Request::segment(2), ['testimonials', 'add_testimonials']) ? 'active  ' : '' }} side-item"
                            href="{{ route('admin.testimonials') }}" aria-expanded="false">
                            <!-- <i class="ti ti-user-circle"></i> -->
                            <i class="fa-solid fa-comment-dots"></i>
                            <span class="hide-menu">Testimonials</span>
                        </a>
                    </li>
                    {{-- <li class="sidebar-item">
                        <a class="sidebar-link {{ in_array(Request::segment(2), ['transactions']) ? 'active  ' : '' }} side-item"
                            href="{{ route('admin.transaction') }}" aria-expanded="false">
                            <i class="ti ti-user-circle"></i>
                            <span class="hide-menu">Transactions</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link {{ in_array(Request::segment(2), ['userplans']) ? 'active  ' : '' }} side-item"
                            href="{{ route('admin.userplan') }}" aria-expanded="false">
                            <i class="ti ti-user-circle"></i>
                            <span class="hide-menu">User Plans</span>
                        </a>
                    </li> --}}
                    <li class="sidebar-item">
                        <a class="sidebar-link justify-content-between has-arrow {{ in_array(Request::segment(2), ['term_conditions', 'privacy_policy', 'edit_user']) ? 'active  btn-orange' : '' }} "
                            href="javascript:void(0)" aria-expanded="false">
                            <div class="d-flex align-items-center gap-3">
                                <span class="d-flex">
                                    <i class="ti ti-files"></i>
                                </span>
                                <span class="hide-menu">Pages Management</span>
                            </div>
                        </a>
                        <ul aria-expanded="false" class="collapse first-level">
                            <li class="sidebar-item">
                                <a class="sidebar-link justify-content-between {{ in_array(Request::segment(2), ['term_conditions']) ? 'active ' : '' }} "
                                    href="{{ route('admin.term_conditions') }}">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="round-16 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-circle"></i>
                                        </div>
                                        <span class="hide-menu">Term & Condition</span>
                                    </div>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link justify-content-between {{ in_array(Request::segment(2), ['privacy_policy']) ? 'active ' : '' }} "
                                    href="{{ route('admin.privacy_policy') }}">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="round-16 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-circle"></i>
                                        </div>
                                        <span class="hide-menu">Privacy & Policy</span>
                                    </div>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link justify-content-between {{ in_array(Request::segment(2), ['social_links']) ? 'active ' : '' }} "
                                    href="{{ route('admin.social_links') }}">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="round-16 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-circle"></i>
                                        </div>
                                        <span class="hide-menu">Social Links</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endauth
            </ul>
        </nav>
    </div>
</aside>
