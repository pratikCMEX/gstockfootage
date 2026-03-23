{{-- ============================================================
     resources/views/admin/dashboard.blade.php
     Extends your admin layout. Inject inside body-wrapper-inner.
     ============================================================ --}}

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/dashboard.css') }}">
@endpush

<div class="body-wrapper-inner">
    <div class="container-fluid">

        {{-- ══════════════════════════════════════════
          ROW 1 — Welcome + Total Orders
     ══════════════════════════════════════════ --}}
        <div class="row2 c-8-4 mb20">

            {{-- Welcome Card --}}
            <div class=" card welcome-main-card">
                <div class=" welcome-card">
                    <div class="user-row">
                        <div class="avatar">
                            <img src="{{ asset('assets/admin/images/profile/user-1.jpg') }}" alt="Admin"
                                onerror="this.style.display='none';this.parentNode.textContent='A'">
                        </div>
                        <h5>Welcome back {{ Auth::guard('affiliate')->user()->first_name }}!</h5>
                    </div>
                    <div class="stats-inline">
                        <div class="si-item">
                            <div class="si-val">${{ number_format($todaySales ?? 0, 2) }} <span class="arr">↗</span>
                            </div>
                            <div class="si-lbl">Today's Sales</div>
                        </div>
                        <div class="si-item">
                            <div class="si-val">{{ date('M d, Y', strtotime($lastMonth ?? date('Y-m-d'))) }}</span>
                            </div>
                            <div class="si-lbl">Overall Performance</div>
                        </div>
                    </div>
                    {{-- 3D illustration --}}
                </div>
                <div class="welcome-bg-img mb-n7 text-end">
                    <img src="{{ asset('assets/admin/images/backgrounds/welcome-bg.svg') }}" alt="modernize-img"
                        class="img-fluid dashboard_img">
                </div>
            </div>

            {{-- Orders Card --}}
            <div class="card orders-card">
                <div class="oc-label">Total Orders</div>
                <div class="oc-num">
                    {{ $totalOrder ?? 0 }}
                    <span class="badge badge-success">↗ </span>
                </div>
                <div id="ordersSparkline"></div>
                <div class="oc-mini">
                    <div class="oc-mini-item green">
                        <div class="lbl">Completed</div>
                        <div class="val">{{ $completedOrders ?? 0 }}</div>
                    </div>
                    <div class="oc-mini-item warn">
                        <div class="lbl">Pending</div>
                        <div class="val">{{ $pendingOrders ?? 0 }}</div>
                    </div>
                    <div class="oc-mini-item blue">
                        <div class="lbl">Revenue</div>
                        <div class="val">${{ number_format($totalRevenue ?? 0, 0) }}</div>
                    </div>
                </div>
            </div>

        </div>

        {{-- ══════════════════════════════════════════
          ROW 2 — 6 Stat Cards
     ══════════════════════════════════════════ --}}
        <div class="row2 c-6s mb20">

            <div class="stat-card blue">
                <div class="sc-row">
                    <div class="sc-icon"><i class="fa-solid fa-users"></i></div>
                    <div>
                        <div class="sc-name">Referrals</div>
                        <div class="sc-num">{{ $refferal_user_count ?? 0 }}</div>
                    </div>
                </div>
            </div>

            <!-- <div class="stat-card red">
                <div class="sc-row">
                    <div class="sc-icon">🎬</div>
                    <div>
                        <div class="sc-name">Videos</div>
                        <div class="sc-num">{{ $totalVideo ?? 0 }}</div>
                    </div>
                </div>
            </div>

            <div class="stat-card green">
                <div class="sc-row">
                    <div class="sc-icon">🖼️</div>
                    <div>
                        <div class="sc-name">Images</div>
                        <div class="sc-num">{{ $totalImage ?? 0 }}</div>
                    </div>
                </div>
            </div>

            <div class="stat-card yellow">
                <div class="sc-row">
                    <div class="sc-icon">🏷️</div>
                    <div>
                        <div class="sc-name">Categories</div>
                        <div class="sc-num">{{ $totalCategory ?? 0 }}</div>
                    </div>
                </div>
            </div>

            <div class="stat-card red">
                <div class="sc-row">
                    <div class="sc-icon">📦</div>
                    <div>
                        <div class="sc-name">Products</div>
                        <div class="sc-num">{{ $totalProduct ?? 0}}</div>
                    </div>
                </div>
            </div>

            <div class="stat-card yellow">
                <div class="sc-row">
                    <div class="sc-icon">💳</div>
                    <div>
                        <div class="sc-name">Subscriptions</div>
                        <div class="sc-num">{{ $totalSubscription ?? 0}}</div>
                    </div>
                </div>
            </div> -->

        </div>

      

      
    </div>
</div>{{-- end .dash-wrap --}}

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.41.0/apexcharts.min.js"></script>

   

    {{-- <script src="{{ asset('assets/admin/js/dashboard.js') }}"></script> --}}
@endpush
