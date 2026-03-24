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
        <div class="row2 c-8-4 mb-20">

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
                            <div class="si-val">${{ number_format($todayEarnings ?? 0, 2) }} <span class="arr">↗</span>
                            </div>
                            <div class="si-lbl">Today's Earning</div>
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


        </div>
        <div class="card orders-card">
            <div class="oc-label">Refferal Link</div>

            {{ $referralLink }}
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
                        <div class="sc-num">{{ $totalReferredUsers ?? 0 }}</div>
                    </div>
                </div>
            </div>

            <div class="stat-card red">
                <div class="sc-row">
                    <div class="sc-icon"><i class="fa-solid fa-dollar-sign"></i></div>
                    <div>
                        <div class="sc-name">Total Earning</div>
                        <div class="sc-num">{{ $totalEarnings ?? 0 }}</div>
                    </div>
                </div>
            </div>

            <div class="stat-card green">
                <div class="sc-row">
                    <div class="sc-icon"><i class="fa-solid fa-list"></i></div>
                    <div>
                        <div class="sc-name">Total Refferal order</div>
                        <div class="sc-num">{{ $totalReferrals ?? 0 }}</div>
                    </div>
                </div>
            </div>

            <div class="stat-card yellow">
                <div class="sc-row">
                    <div class="sc-icon">⏳</div>
                    <div>
                        <div class="sc-name">Pending Amount</div>
                        <div class="sc-num">{{ $pendingAmount ?? 0 }}</div>
                    </div>
                </div>
            </div>

            <div class="stat-card red">
                <div class="sc-row">
                    <div class="sc-icon">💰</div>
                    <div>
                        <div class="sc-name">Paid Amount</div>
                        <div class="sc-num">{{ $paidAmount ?? 0}}</div>
                    </div>
                </div>
            </div>

            <div class="stat-card yellow">
                <div class="sc-row">
                    <div class="sc-icon">📊</div>
                    <div>
                        <div class="sc-name">Commission info </div>
                        <div class="sc-num"><span style="font-size: 20px;">{{ $commissionInfo ?? 0}}</span></div>
                    </div>
                </div>
            </div>

        </div>




    </div>
</div>{{-- end .dash-wrap --}}

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.41.0/apexcharts.min.js"></script>



    {{--
    <script src="{{ asset('assets/admin/js/dashboard.js') }}"></script> --}}
@endpush