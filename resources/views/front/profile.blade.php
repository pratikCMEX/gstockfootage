<style>
    /* ── Google Font ── */
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=DM+Mono:wght@500&display=swap');

    /* ── Tokens (uses your existing CSS variables where possible) ── */
    :root {
        --order-font: 'DM Sans', sans-serif;
        --order-mono: 'DM Mono', monospace;
        --order-radius: 14px;
        --order-radius-sm: 8px;
        --order-orange: #e67000;
        --order-orange-bg: #fff4e6;
        --order-orange-bd: #ffd199;
        --order-green: #1a7a40;
        --order-green-bg: #e8f7ee;
        --order-green-bd: #a8d8bc;
        --order-surface: #ffffff;
        --order-surface-2: #f8f8f8;
        --order-border: rgba(0, 0, 0, .08);
        --order-border-md: rgba(0, 0, 0, .12);
        --order-text: #111111;
        --order-muted: #737373;
        --order-shadow: 0 1px 3px rgba(0, 0, 0, .06), 0 4px 16px rgba(0, 0, 0, .04);
        --order-shadow-lg: 0 4px 24px rgba(0, 0, 0, .10);
    }

    /* ── Wrapper per order ── */
    .batch-content {
        font-family: var(--order-font);
        background: var(--order-surface);
        border: 1px solid var(--order-border);
        border-radius: var(--order-radius);
        box-shadow: var(--order-shadow);
        margin-bottom: 16px;
        overflow: hidden;
        transition: box-shadow .2s ease;
    }

    .batch-content:hover {
        box-shadow: var(--order-shadow-lg);
    }

    /* ── Header row ── */
    .batch-content-detail {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 18px 22px;
    }

    /* ── Left meta block ── */
    .batch-content-create {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 6px 20px;
    }

    .batch-content-create p {
        margin: 0;
        line-height: 1.4;
    }

    /* Order ID */
    .batch-content-create .batchid:first-child {
        font-family: var(--order-mono);
        font-size: 13px;
        font-weight: 500;
        color: var(--order-text);
        letter-spacing: .01em;
        width: 100%;
        /* full row on its own line */
        margin-bottom: 4px;
    }

    /* Date */
    .batch-content-create .batchcreated {
        font-size: 12px;
        color: var(--order-muted);
    }

    /* Total Amount */
    .batch-content-create .batchid.total-amount {
        font-size: 20px;
        font-weight: 600;
        color: var(--order-orange);
        letter-spacing: -.01em;
    }

    /* Status */
    .batch-content-create .batchid.order-status {
        display: inline-flex;
        align-items: center;
        font-size: 11px;
        font-weight: 500;
        padding: 3px 11px;
        border-radius: 20px;
        letter-spacing: .04em;
        text-transform: capitalize;
        background: var(--order-green-bg);
        color: var(--order-green);
        border: 1px solid var(--order-green-bd);
    }

    /* ── More Detail button ── */
    .more-detail {
        flex-shrink: 0;
    }

    .more-detail-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-family: var(--order-font);
        font-size: 12px;
        font-weight: 500;
        color: var(--order-muted);
        background: transparent;
        border: 1px solid var(--order-border-md);
        border-radius: var(--order-radius-sm);
        padding: 7px 14px;
        cursor: pointer;
        transition: background .15s, color .15s, border-color .15s;
        white-space: nowrap;
    }

    .more-detail-btn:hover {
        background: var(--order-surface-2);
        color: var(--order-text);
        border-color: rgba(0, 0, 0, .2);
    }

    .more-detail-btn i {
        font-size: 11px;
        transition: transform .25s ease;
    }

    .more-detail-btn.open i {
        transform: rotate(180deg);
    }

    /* ── Table wrapper ── */
    .batch-content-table-details {
        /* border-top: 1px solid var(--order-border); */
        background: var(--order-surface-2);
        padding: 0;
    }

    .table-scroll {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    /* ── Table ── */
    .batch-content-table-details .table {
        width: 100%;
        border-collapse: collapse;
        margin: 0;
        font-size: 13px;
    }

    .batch-content-table-details .table thead tr {
        background: #f2f2f2;
        border-bottom: 1px solid var(--order-border-md);
    }

    .batch-content-table-details .table thead th {
        font-size: 11px;
        font-weight: 500;
        color: var(--order-muted);
        text-transform: uppercase;
        letter-spacing: .06em;
        padding: 10px 18px;
        border: none;
        white-space: nowrap;
    }

    .batch-content-table-details .table tbody tr {
        border-bottom: 1px solid var(--order-border);
        transition: background .12s;
    }

    .batch-content-table-details .table tbody tr:last-child {
        border-bottom: none;
    }

    .batch-content-table-details .table tbody tr:hover {
        background: #fff;
    }

    .batch-content-table-details .table td {
        padding: 14px 18px;
        vertical-align: middle;
        border: none;
        color: var(--order-text);
    }

    /* Product thumbnail */
    .batch-content-table-details .table td img {
        width: 54px;
        height: 54px;
        object-fit: cover;
        border-radius: 9px;
        border: 1px solid var(--order-border);
        display: block;
    }

    /* Type pill */
    .product-type-pill {
        display: inline-block;
        font-size: 11px;
        font-weight: 500;
        padding: 3px 10px;
        border-radius: 6px;
        background: var(--order-orange-bg);
        color: #b85c00;
        border: 1px solid var(--order-orange-bd);
        text-transform: capitalize;
    }

    /* Product name */
    .product-title {
        font-weight: 500;
        color: var(--order-text);
    }

    /* Price cell */
    .product-price {
        font-weight: 600;
        color: var(--order-text);
        white-space: nowrap;
    }

    .order-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-shrink: 0;
    }

    .invoice-btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        font-family: var(--font-inter-medium), 'DM Sans', sans-serif;
        font-size: 12px;
        font-weight: 500;
        color: var(--white);
        background: var(--primary);
        border: none;
        border-radius: 8px;
        padding: 8px 15px;
        cursor: pointer;
        text-decoration: none;
        transition: background .18s, transform .12s;
        white-space: nowrap;
        line-height: 1;
    }

    .invoice-btn:hover {
        background: var(--primary-hover);
        color: var(--white);
        transform: translateY(-1px);
        text-decoration: none;
    }

    .invoice-btn:active {
        transform: translateY(0);
    }

    .invoice-btn svg {
        width: 13px;
        height: 13px;
        flex-shrink: 0;
    }

    /* ── Pagination ── */
    .pagination-wrapper {
        display: flex;
        justify-content: flex-end;
        padding: 24px 0 8px;
    }

    .pagination-links {
        display: flex;
        align-items: center;
    }

    .pagination-links .pagination {
        display: flex;
        align-items: center;
        gap: 4px;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .pagination-links .pagination li span,
    .pagination-links .pagination li a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 36px;
        height: 36px;
        padding: 0 10px;
        font-family: var(--font-inter-medium), 'DM Sans', sans-serif;
        font-size: 13px;
        font-weight: 500;
        border-radius: 8px;
        border: 1px solid transparent;
        text-decoration: none;
        transition: background .15s, color .15s, border-color .15s;
        color: var(--second-text);
        background: transparent;
        line-height: 1;
    }

    .pagination-links .pagination li a:hover {
        background: var(--badge-color);
        color: var(--primary);
        border-color: rgba(255, 128, 0, .25);
    }

    .pagination-links .pagination li.active span,
    .pagination-links .pagination li span[aria-current="page"] {
        background: var(--primary);
        color: var(--white);
        border-color: var(--primary);
        font-weight: 600;
        cursor: default;
    }

    .pagination-links .pagination li.disabled span {
        opacity: .35;
        cursor: not-allowed;
        background: transparent;
        color: var(--second-text);
    }

    .pagination-links .pagination li:first-child a,
    .pagination-links .pagination li:last-child a,
    .pagination-links .pagination li:first-child span,
    .pagination-links .pagination li:last-child span {
        padding: 0 13px;
        color: var(--text);
        background: var(--white);
        border-color: rgba(0, 0, 0, .10);
    }

    .pagination-links .pagination li:first-child a:hover,
    .pagination-links .pagination li:last-child a:hover {
        background: var(--badge-color);
        color: var(--primary);
        border-color: rgba(255, 128, 0, .3);
    }

    /* Per-product download icon */
    .product-dl-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        border-radius: 8px;
        border: 1px solid rgba(255, 128, 0, .30);
        background: var(--badge-color);
        color: var(--primary);
        cursor: pointer;
        text-decoration: none;
        transition: background .15s, border-color .15s, transform .12s;
        flex-shrink: 0;
    }

    .product-dl-btn:hover {
        background: var(--primary);
        border-color: var(--primary);
        color: var(--white);
        transform: translateY(-1px);
        text-decoration: none;
    }

    .product-dl-btn:active {
        transform: translateY(0);
    }

    .product-dl-btn svg {
        width: 14px;
        height: 14px;
    }

    .pagination-links .small.text-muted {
        margin-right: 10px
    }
</style>
<main>
    <section class="profile_section">
        <div class="container">
            <div class="profile-content-main">
                <div class="profile-left">
                    <div class="profile-content">
                        <div class="profile-img">
                            <img src=" 
                            @if(isset($user_profile->profile_image)) 
                             {{ asset('uploads/images/profile_image/' . $user_profile->profile_image) }} 
                             @else
                              {{ asset('assets/front/img/demo_profile.jpg') }} 
                              @endif 
                              " height="100%" width="100%" alt="">
                        </div>
                        <div class="profile-name">
                            <h4>{{ $user_profile->first_name . ' ' . $user_profile->last_name }}</h4>
                            <p> Member</p>
                        </div>
                    </div>
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <button
                            class="nav-link btn profile-btn @if (request()->get('tab') == 'profile' || !request()->get('tab')) active @endif"
                            id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button"
                            role="tab" aria-controls="v-pills-home" aria-selected="true"><i class="bi bi-person"></i>
                            Profile</button>
                        <button
                            class="nav-link btn profile-btn @if (request()->get('tab') == 'downloads') active @endif"
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
                <div class="tab-content profile-right" id="v-pills-tabContent">
                    <div class="tab-pane fade @if (request()->get('tab') === 'profile' || empty(request()->get('tab'))) show active @endif"
                        id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab" tabindex="0">
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
                                        <img src="{{ $user_profile->profile_image ? asset('uploads/images/profile_image/' . $user_profile->profile_image) : asset('assets/front/img/demo_profile.jpg') }}" width="100%"
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
                                    <!-- <div class="profile-number profile-manage-text">
                                        <span>Phone Number</span>
                                        <a
                                            href="tel:+1 (555) 000-1234">{{ $user_profile->phone ? $user_profile->phone : '-' }}</a>
                                    </div> -->
                                    <div class="profile-number profile-manage-text">
                                        <span>Phone Number</span>
                                        @if ($user_profile->phone)
                                            @php
                                                $phone = $user_profile->phone;
                                                $countryCode = $user_profile->country_code ?? '';
                                                $cleanPhone = preg_replace('/[^0-9]/', '', $phone);

                                                // Format only if country code exists
                                                $formatted = $countryCode
                                                    ? formatPhoneByCountry($phone, $countryCode)
                                                    : $phone; // show raw phone if no country code
                                            @endphp

                                            <a href="tel:{{ $countryCode }}{{ $cleanPhone }}"
                                                style="color: inherit; text-decoration: none;">
                                                {{ $countryCode ? $countryCode . ' ' . $formatted : $formatted }}
                                            </a>
                                        @else
                                            <p>-</p>
                                        @endif
                                    </div>
                                    <div class="profile-language profile-manage-text">
                                        <span>Language</span>
                                        <p>English</p>
                                    </div>
                                </div>
                            </div>
                        </div>


                        @if (!empty($purchasePlan))
                            @php

                                $created = \Carbon\Carbon::parse($purchasePlan->subscription->created_at);
                                $renewDate = $created; // default value
                                $billingText = '';
                                if ($purchasePlan->subscription->duration_type == 'Month') {
                                    $renewDate = $created->addMonths($purchasePlan->subscription->duration_value);
                                    $billingText = 'monthly';
                                } elseif ($purchasePlan->subscription->duration_type == 'Year') {
                                    $renewDate = $created->addYears($purchasePlan->subscription->duration_value);
                                    $billingText = 'yearly';
                                } elseif ($purchasePlan->subscription->duration_type == 'Quarter') {
                                    $renewDate = $created->addMonths($purchasePlan->subscription->duration_value * 3);
                                    $billingText = 'quarterly';
                                }

                            @endphp
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
                                            <p class="text-secondary">{{ $purchasePlan->subscription->total_clips }}
                                                HD
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
                                            <circle cx="7" cy="7" r="6" stroke="#ccc" stroke-width="1.2"></circle>
                                            <path d="M7 4v3.5l2 1.2" stroke="#aaa" stroke-width="1.2"
                                                stroke-linecap="round"></path>
                                        </svg>
                                        Plan valid till
                                        <strong>{{ $purchasePlan?->end_date ? \Carbon\Carbon::parse($purchasePlan->end_date)->format('F d, Y') : 'N/A' }}</strong>
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
                        id="v-pills-profile" role="tabpanel">
                        @if ($order_data->isNotEmpty())
                            <div class="heading">
                                <h2>Recent Orders

                                </h2>
                            </div>
                            <div class="">
                                {{-- @foreach ($order_data as $order)
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

                                                <tbody>
                                                    @foreach ($order->order_details as $detail)
                                                    @php
                                                    $product = $detail->product;

                                                    if ($product && $product->type == 'image') {
                                                    $path = $product->low_path;
                                                    } else {
                                                    $path = $product->thumbnail_path ?? null;
                                                    }

                                                    $url = $path
                                                    ? Storage::disk('s3')->url($path)
                                                    : asset('assets/admin/images/demo_thumbnail.png');
                                                    @endphp

                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center gap-2">
                                                                <img src="{{ $url }}" width="60" height="60">

                                                            </div>
                                                        </td>
                                                        <td>{{ $detail->product->type }}</td>
                                                        <td>{{ $detail->product->title }}</td>
                                                        <td>$ {{ $detail->product->price }}</td>

                                                        <!-- <td>
                                                                                                                                                                                                            <span class="badge bg-success">
                                                                                                                                                                                                                {{ ucfirst($file['status'] ?? 'accepted') }}
                                                                                                                                                                                                            </span>
                                                                                                                                                                                                        </td> -->
                                                    </tr>
                                                    @endforeach
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>

                                </div>
                                @endforeach --}}
                                @foreach ($order_data as $order)
                                    <div class="batch-content">

                                        <div class="batch-content-detail">

                                            <div class="batch-content-create">
                                                {{-- Order ID --}}
                                                <p class="batchid">Order ID : {{ $order->order_number }}</p>

                                                {{-- Date --}}
                                                <p class="batchcreated">
                                                    Date :
                                                    {{ \Carbon\Carbon::parse($order->created_at)->format('M d, Y') }}
                                                </p>

                                                {{-- Total Amount — extra class added for styling only --}}
                                                <p class="batchid total-amount">Total Amount :
                                                    ${{ $order->total_amount }}</p>

                                                {{-- Status — extra class added for styling only --}}
                                                <p class="batchid order-status">{{ $order->order_status }}</p>
                                            </div>

                                            <div class="order-actions">

                                                {{-- Invoice Download Button --}}
                                                {{-- <a href="{{ route('orders.invoice', $order->id) }}" --}} <a href="#"
                                                    class="invoice-btn d-none" title="Download Invoice">
                                                    <svg viewBox="0 0 14 14" fill="none" stroke="currentColor"
                                                        stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M7 1v8M4 6l3 3 3-3" />
                                                        <path d="M2 10v1a1 1 0 001 1h8a1 1 0 001-1v-1" />
                                                    </svg>
                                                    Invoice
                                                </a>

                                                {{-- More Detail Toggle --}}
                                                <button class="btn more-detail-btn" type="button">
                                                    <i class="fa-solid fa-angle-down"></i> More Detail
                                                </button>

                                            </div>
                                        </div>

                                        {{-- DETAILS TABLE --}}
                                        <div class="batch-content-table-details d-none">
                                            <div class="table-scroll">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Product</th>
                                                            <th>Product Type</th>
                                                            <th>Product Name</th>
                                                            <th>Price</th>
                                                            <th>Download</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @foreach ($order->order_details as $detail)
                                                            @php
                                                                $product = $detail->product;

                                                                if ($product && $product->type == 'image') {
                                                                    $path = $product->mid_path;
                                                                } else {
                                                                    $path = $product->thumbnail_path ?? null;
                                                                }

                                                                $url = $path
                                                                    ? Storage::disk('s3')->url($path)
                                                                    : asset('assets/admin/images/demo_thumbnail.png');
                                                                $final_url = Storage::disk('s3')->url(
                                                                    $product->file_path,
                                                                );

                                                            @endphp

                                                            <tr>
                                                                <td>
                                                                    <div class="d-flex align-items-center gap-2">
                                                                        <img src="{{ $url }}" width="60" height="60">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        class="product-type-pill">{{ $detail->product->type }}</span>
                                                                </td>
                                                                <td>
                                                                    <span class="product-title">{{ $detail->product->title }}</span>
                                                                </td>
                                                                <td>
                                                                    <span class="product-price">$
                                                                        {{ $detail->product->price }}</span>
                                                                </td>
                                                                <td>
                                                                    @php
                                                                        $downloadUrl = $product->file_path
                                                                            ? Storage::disk('s3')->temporaryUrl(
                                                                                $product->file_path,
                                                                                now()->addMinutes(30),
                                                                                [
                                                                                    'ResponseContentDisposition' =>
                                                                                        'attachment; filename="' .
                                                                                        basename($product->file_path) .
                                                                                        '"',
                                                                                ],
                                                                            )
                                                                            : null;
                                                                    @endphp
                                                                    @if ($downloadUrl)
                                                                        <a href="{{ $downloadUrl }}" class="product-dl-btn" download
                                                                            title="Download {{ $detail->product->title }}">
                                                                            <svg viewBox="0 0 14 14" fill="none" stroke="currentColor"
                                                                                stroke-width="1.6" stroke-linecap="round"
                                                                                stroke-linejoin="round">
                                                                                <path d="M7 1v8M4 6l3 3 3-3" />
                                                                                <path d="M2 10v1a1 1 0 001 1h8a1 1 0 001-1v-1" />
                                                                            </svg>
                                                                        </a>
                                                                    @else
                                                                        <span class="product-dl-btn"
                                                                            style="opacity:.35;cursor:not-allowed;"
                                                                            title="Not available">
                                                                            <svg viewBox="0 0 14 14" fill="none" stroke="currentColor"
                                                                                stroke-width="1.6" stroke-linecap="round"
                                                                                stroke-linejoin="round">
                                                                                <path d="M7 1v8M4 6l3 3 3-3" />
                                                                                <path d="M2 10v1a1 1 0 001 1h8a1 1 0 001-1v-1" />
                                                                            </svg>
                                                                        </span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                @endforeach
                                <div class="pagination-wrapper">
                                    <div class="pagination-links ms-auto">
                                        {{ $order_data->appends(['tab' => 'downloads'])->links() }}
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="col-12 mt-4">
                                <div class="empty-wishlist text-center ">



                                    <h4>Your Download History is Empty</h4>

                                    <p>
                                        You haven't Purchase any items yet.

                                    </p>

                                    <a href="{{ url('/') }}" class="btn btn-orange mt-2">
                                        Browse Products
                                    </a>

                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="tab-pane fade profile-wishlist @if (request()->get('tab') == 'wishlist') show active @endif"
                        id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab" tabindex="0">
                        <div class="wishlist-content">
                            <div class="wishlist-heading">
                                <div class="heading">
                                    <h2 class="mb-0">Wishlist</h2>
                                </div>
                                <!-- <p class="item-count">3 items</p> -->
                            </div>
                            <div class="wishlist-product-content">
                                <div class="row row-gap-4">

                                    @if ($wishLists->isNotEmpty() && !empty($wishLists))
                                        @foreach ($wishLists as $favorites)
                                            <div class="col-lg-4 col-md-6 col-xs-12 wishlist-item">
                                                <div class="wishlist-product-detail">
                                                    <div class="product-card">
                                                        <div class="product-img-div">
                                                            <a
                                                                href="{{ route('product.detail', encrypt($favorites->batchFile->id)) }}">
                                                                @if ($favorites->batchFile->type == 'image')
                                                                    <img src="{{ Storage::disk('s3')->url($favorites->batchFile->file_path) }}"
                                                                        class="product-img" alt="">
                                                                @else
                                                                    <video class="product-img" controls width="100%"
                                                                        poster="{{ !empty($favorites->batchFile->thumbnail_path) ? Storage::disk('s3')->url($favorites->batchFile->thumbnail_path) : asset('assets/admin/images/demo_thumbnail.png') }}">

                                                                        <source
                                                                            src="{{ Storage::disk('s3')->url($favorites->batchFile->file_path) }}"
                                                                            type="video/mp4">
                                                                        Your browser does not support the video tag.
                                                                    </video>
                                                                @endif
                                                            </a>
                                                            <div class="remove-product"><a class="removeFavorite"
                                                                    data-id="{{ encrypt($favorites->id) }}"><i
                                                                        class="bi bi-x"></i></a></div>
                                                        </div>
                                                        <div class="p-3">
                                                            <a
                                                                href="{{ route('product.detail', encrypt($favorites->batchFile->id)) }}">
                                                                <h6 class="popular-detail-title">
                                                                    {{ $favorites->batchFile->title }}
                                                                </h6>
                                                            </a>
                                                            <div class="price-btn">
                                                                <span
                                                                    class="price mb-0">${{ $favorites->batchFile->price }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="col-12 mt-4">
                                            <div class="empty-wishlist text-center ">



                                                <h4>Your Wishlist is Empty</h4>

                                                <p>
                                                    You haven't added any items to your wishlist yet.
                                                    Browse products and add your favorites here.
                                                </p>

                                                <a href="{{ url('/') }}" class="btn btn-orange mt-2">
                                                    Browse Products
                                                </a>

                                            </div>
                                        </div>
                                    @endif
                                    <!-- <div class="col-lg-4 col-md-6 col-xs-12">
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
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade profile-setting @if (request()->get('tab') == 'settings') show active @endif"
                        id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab" tabindex="0">
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
                                        <p>{{ $user_profile->first_name . ' ' . $user_profile->last_name }}</p>
                                    </div>
                                    <div>
                                        <span>Email Address</span>
                                        <p>{{ $user_profile->email ?? '' }}</p>
                                    </div>
                                    <div>
                                        <span>Phone Number</span>
                                        @if ($user_profile->phone)
                                            @php
                                                $phone = $user_profile->phone;
                                                $countryCode = $user_profile->country_code ?? '';
                                                $cleanPhone = preg_replace('/[^0-9]/', '', $phone);

                                                $formatted = $countryCode
                                                    ? formatPhoneByCountry($phone, $countryCode)
                                                    : $phone;
                                            @endphp

                                            <a href="tel:{{ $countryCode }}{{ $cleanPhone }}"
                                                style="color: inherit; text-decoration: none;">
                                                <p>{{ $countryCode ? $countryCode . ' ' . $formatted : $formatted }}
                                                </p>
                                            </a>
                                        @else
                                            <p>-</p>
                                        @endif
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
                                        <p>Last changed
                                            {{ \Carbon\Carbon::parse($user_profile->password_updated_at)->diffForHumans() }}
                                        </p>
                                    </div>
                                    <button type="button" class="btn profile-heading-btn btn-all-dark btn-hover-dark"
                                        data-bs-toggle="modal" data-bs-target="#password_change">
                                        <i class="bi bi-pencil"></i>
                                        Change
                                    </button>
                                    <!-- <button type="button"
                                        class="btn btn-all-dark btn-hover-dark pass-btn">Change</button> -->
                                </div>
                                <!-- <div class="security-two-factor security-detail">
                                    <div class="pass-title">
                                        <h4>Two-factor Auth</h4>
                                        <p>Protects your account with extra security</p>
                                    </div>
                                    <button type="button" class="btn btn-orange">Enable</button>
                                </div> -->
                            </div>
                        </div>
                    </div>


                </div>

            </div>
            <!-- Modal -->
            <div class="modal fade profile-modal " id="staticBackdrop" data-bs-backdrop="static"
                data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog  modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title" id="staticBackdropLabel">Edit Profile</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('front.update_profile') }}" method="POST" name="profile_form"
                            id="profile_form" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body p-0">
                                <div class="modal-inp-label">
                                    <input type="hidden" name="user_id" value="{{ encrypt($user_profile->id) }}">
                                    <label>First Name<span class="text-danger">*</span></label>
                                    <input type="text" name="first_name" id="first_name" class="form-control"
                                        value="{{ $user_profile->first_name }}" placeholder="Enter Your First Name">
                                </div>
                                <div class="modal-inp-label">
                                    <label>Last Name<span class="text-danger">*</span></label>
                                    <input type="text" name="last_name" id="last_name" class="form-control"
                                        value="{{ $user_profile->last_name }}" placeholder="Enter Your Last Name">
                                </div>
                                <div class="modal-inp-label">
                                    <label>Email<span class="text-danger">*</span></label>
                                    <input type="email" name="email" id="email" class="form-control"
                                        placeholder="you@example.com" value="{{ $user_profile->email }}">
                                </div>
                                <div>
                                    <label>Phone No</label>
                                    <div class="input-group phone-input">
                                        <input type="tel" id="phone" name="phone_number" class="form-control"
                                            placeholder="Enter your phone number"
                                            value="{{ $user_profile->phone ?? '' }}"
                                            oninput="this.value = this.value.replace(/[^0-9-]/g,'')">
                                    </div>

                                    {{-- Hidden fields --}}
                                    <input type="hidden" name="phone" id="full_phone"
                                        value="{{ $user_profile->phone ?? '' }}">
                                    <input type="hidden" name="country_code" id="country_code"
                                        value="{{ $user_profile->country_code ?? '' }}">
                                </div>

                                <div>
                                    <label>Profile Image</label>

                                    <!-- Preview -->


                                    <!-- File input -->
                                    <input type="file" name="profile_image" id="profile_image" class="form-control"
                                        accept="image/*">

                                    <div class="mb-2 mt-2">
                                        @if($user_profile->profile_image)
                                            <img id="imagePreview"
                                                src="{{ $user_profile->profile_image ? asset('uploads/images/profile_image/' . $user_profile->profile_image) : asset('assets/front/img/default-user.png') }}"
                                                style="width:80px; height:80px; border-radius:10px; object-fit:cover;">
                                        @endif
                                    </div>
                                </div>

                                <!-- <div>
                                    <label>Phone No</label>

                                    <div class="input-group  phone-input">
                                        <input type="tel" id="phone" name="phone_number" class="form-control"
                                            placeholder="Enter your phone number"
                                            value="{{ $user_profile->phone ?? '' }}"
                                            oninput="this.value = this.value.replace(/[^0-9-]/g,'')">
                                    </div>

                                    Hidden field that stores full phone
                                    <input type="hidden" name="phone" id="full_phone"
                                        value="{{ $user_profile->phone ?? '' }}">

                                </div> -->
                                <!-- <div class="modal-inp-label">
                                <label>Phone No</label>
                                <input type="tel" name="phone" id="phone" class="form-control"
                                    placeholder="Enter Phone no" value="{{ $user_profile->phone ?? '' }}">
                            </div> -->
                                <div class="modal-inp-label">
                                    <label>Address</label>
                                    <textarea name="address"
                                        class="form-control">{{ $user_profile->address ?? '' }}</textarea>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-all-dark btn-hover-dark"
                                    data-bs-dismiss="modal">Cancle</button>
                                <button type="submit" class="btn btn-orange">Edit Profile</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade password-modal " id="password_change" data-bs-backdrop="static"
                data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                                    <input type="hidden" name="id" value="{{ $user_profile->id ?? '' }}">
                                    <label>Current Password</label>
                                    <input type="password" name="current_password" id="current_password"
                                        class="form-control" placeholder="Enter Current Password">
                                </div>
                                <div class="modal-inp-label">
                                    <label>New Password</label>
                                    <input type="password" name="new_password" id="new_password" class="form-control"
                                        placeholder="Enter New Password">
                                </div>
                                <div class="modal-inp-label">
                                    <label>Confirm Password</label>
                                    <input type="password" name="confirm_password" id="confirm_password"
                                        class="form-control" placeholder="Enter Confirm Password">
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
                                    <input type="text" name="username" class="form-control"
                                        placeholder="Enter Your Name">
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
{{--
<script>
    document.querySelectorAll('.more-detail-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var card = btn.closest('.batch-content');
            var table = card.querySelector('.batch-content-table-details');
            var isOpen = !table.classList.contains('d-none');

            table.classList.toggle('d-none', isOpen);
            btn.classList.toggle('open', !isOpen);
            btn.innerHTML = isOpen ?
                '<i class="fa-solid fa-angle-down"></i> More Detail' :
                '<i class="fa-solid fa-angle-up"></i> Less Detail';
        });
    });
</script> --}}