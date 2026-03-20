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
                        <h5>Welcome back Admin!</h5>
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
                    <div class="sc-icon"><i class="fa-solid fa-user"></i></div>
                    <div>
                        <div class="sc-name">Users</div>
                        <div class="sc-num">{{ $totalUser }}</div>
                    </div>
                </div>
            </div>

            <div class="stat-card red">
                <div class="sc-row">
                    <div class="sc-icon">🎬</div>
                    <div>
                        <div class="sc-name">Videos</div>
                        <div class="sc-num">{{ $totalVideo }}</div>
                    </div>
                </div>
            </div>

            <div class="stat-card green">
                <div class="sc-row">
                    <div class="sc-icon">🖼️</div>
                    <div>
                        <div class="sc-name">Images</div>
                        <div class="sc-num">{{ $totalImage }}</div>
                    </div>
                </div>
            </div>

            <div class="stat-card yellow">
                <div class="sc-row">
                    <div class="sc-icon">🏷️</div>
                    <div>
                        <div class="sc-name">Categories</div>
                        <div class="sc-num">{{ $totalCategory }}</div>
                    </div>
                </div>
            </div>

            <div class="stat-card red">
                <div class="sc-row">
                    <div class="sc-icon">📦</div>
                    <div>
                        <div class="sc-name">Products</div>
                        <div class="sc-num">{{ $totalProduct }}</div>
                    </div>
                </div>
            </div>

            <div class="stat-card yellow">
                <div class="sc-row">
                    <div class="sc-icon">💳</div>
                    <div>
                        <div class="sc-name">Subscriptions</div>
                        <div class="sc-num">{{ $totalSubscription }}</div>
                    </div>
                </div>
            </div>

        </div>

        {{-- ══════════════════════════════════════════
          ROW 3 — Monthly Revenue + Content Donut
     ══════════════════════════════════════════ --}}
        <div class="row2 c-8-4 mb20">

            <div class="card">
                <div class="card-head">
                    <div>
                        <h3>Monthly Revenue</h3>
                        <div class="sub">Paid order revenue — last 6 months</div>
                    </div>
                    <div style="display:flex;align-items:center;gap:10px;">
                        <span style="display:flex;align-items:center;gap:5px;font-size:12px;color:var(--muted);">
                            <span
                                style="width:10px;height:10px;border-radius:50%;background:#5d87ff;display:inline-block;"></span>Revenue
                        </span>
                        <button class="btn-sm">Last 6 Mo</button>
                    </div>
                </div>
                <div class="card-body" style="padding-bottom:8px;">
                    <div id="revenueChart"></div>
                </div>
            </div>

            <div class="card">
                <div class="card-head">
                    <div>
                        <h3>Content Split</h3>
                        <div class="sub">Images vs Videos</div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="contentDonut"></div>
                </div>
            </div>

        </div>

        {{-- ══════════════════════════════════════════
          ROW 4 — Subscription Plans + Top Categories
     ══════════════════════════════════════════ --}}
        <div class="row2 c-2 mb20">

            <div class="card">
                <div class="card-head">
                    <div>
                        <h3>Subscription Plans</h3>
                        <div class="sub">Active plan pricing</div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="subBar"></div>
                    <div id="planList" style="margin-top:14px;"></div>
                </div>
            </div>

            <div class="card">
                <div class="card-head">
                    <div>
                        <h3>Top Categories</h3>
                        <div class="sub">Files per category</div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="categoryBar"></div>
                </div>
            </div>

        </div>

        {{-- ══════════════════════════════════════════
          ROW 5 — Recent Orders + Activity Feed
     ══════════════════════════════════════════ --}}
        <div class="row2 c-2 mb20">

            {{-- Recent Orders --}}
            <div class="card">
                <div class="card-head">
                    <h3>Recent Orders</h3>
                    <a class="btn-sm" href="{{ route('admin.order_history') }}">See All <i class="fa-solid fa-arrow-right-long"></i></a>
                </div>
                <div class="card-table-main">
                    <table class="tbl">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Amount</th>
                                <th>Payment</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders ?? [] as $order)
                                <tr>
                                    <td><strong>{{ $order->order_number }}</strong></td>
                                    <td class="fw7">${{ number_format($order->total_amount, 2) }}</td>
                                    <td><span
                                            class="pill {{ $order->payment_status }}">{{ ucfirst($order->payment_status) }}</span>
                                    </td>
                                    <td><span
                                            class="pill {{ $order->order_status }}">{{ ucfirst($order->order_status) }}</span>
                                    </td>
                                    <td class="c-muted fs12">{{ $order->created_at->format('M d, Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align:center;padding:28px;color:var(--muted);">No
                                        orders
                                        yet</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Activity Feed --}}
            <div class="card">
                <div class="card-head">
                    <h3>Recent Activity</h3>
                </div>

                @forelse ($recentActivity as $activity)
                    <div class="act-item">
                        <div class="act-dot {{ $activity['dot'] }}">
                            {!! $activity['icon'] !!}
                        </div>
                        <div>
                            <div class="act-title">{{ $activity['title'] }}</div>
                            <div class="act-sub">{{ $activity['sub'] }}</div>
                        </div>
                        <div class="act-time">
                            {{ $activity['time'] ? $activity['time']->diffForHumans() : '—' }}
                        </div>
                    </div>
                @empty
                    <div class="act-item">
                        <div class="act-sub">No recent activity found.</div>
                    </div>
                @endforelse
            </div>

        </div>

        {{-- ══════════════════════════════════════════
          ROW 6 — Recent Batch Files
     ══════════════════════════════════════════ --}}
        {{-- <div class="card mb20">
            <div class="card-head">
                <h3>Recent Batch Files</h3>
                <a class="btn-sm" href="#">See All <i class="fa-solid fa-arrow-right-long"></i></a>
            </div>
            <div class="card-table-main">
                <table class="tbl">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Size</th>
                            <th>Status</th>
                            <th>Price</th>
                            <th>Uploaded</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentFiles ?? [] as $file)
                            <tr>
                                <td><strong>{{ $file->title ?? $file->original_name }}</strong></td>
                                <td>
                                    <span
                                        class="badge {{ $file->type === 'video' ? 'badge-danger' : 'badge-primary' }}">
                                        {{ ucfirst($file->type) }}
                                    </span>
                                </td>
                                <td class="c-muted fs12">
                                    {{ $file->file_size ? number_format($file->file_size / 1048576, 1) . ' MB' : '—' }}
                                </td>
                                <td><span
                                        class="pill {{ str_replace('_', '-', $file->status) }}">{{ ucfirst(str_replace('_', ' ', $file->status)) }}</span>
                                </td>
                                <td class="fw7">{{ $file->price ? '$' . number_format($file->price, 2) : '—' }}
                                </td>
                                <td class="c-muted fs12">{{ $file->created_at->format('M d, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align:center;padding:28px;color:var(--muted);">No files
                                    yet
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div> --}}

        {{-- <div class="dash-footer">Design and Developed by <a href="#">Gstockfootage</a></div> --}}
    </div>
</div>{{-- end .dash-wrap --}}

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.41.0/apexcharts.min.js"></script>

    <script>
        window.dashData = {
            ordersTrend: @json($ordersTrend),
            monthlyRevenue: @json($monthlyRevenue),
            monthlyLabels: @json($monthlyLabels),
            totalImages: {{ $totalImage }},
            totalVideos: {{ $totalVideo }},
            categoryLabels: @json($categoryLabels),
            categoryCounts: @json($categoryCounts),
            planNames: @json($planNames),
            planPrices: @json($planPrices),
            plans: @json($planList)
        };
    </script>

    {{-- <script src="{{ asset('assets/admin/js/dashboard.js') }}"></script> --}}
@endpush
