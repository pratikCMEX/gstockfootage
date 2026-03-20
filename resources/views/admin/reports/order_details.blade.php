<div class="body-wrapper-inner">
    <div class="container-fluid">
        <div class="order-detail-wrapper">

            {{-- Page Header --}}

            <div class="order-page-header">
                <h4><i class="bi bi-receipt me-2"></i>Order Detail</h4>
                <a href="{{ route('admin.order_history') }}" class="back-btn">
                    <i class="bi bi-arrow-left"></i> Back to Orders
                </a>
            </div>

            {{-- Order Summary Top Banner --}}
            <div class="order-summary-top">
                <div class="order-number-block">
                    <h3>#{{ $order->order_number }}</h3>
                    <span>Placed on {{ $order->created_at->format('d M Y, h:i A') }}</span>
                </div>
                <div class="order-badges">
                    @php
                        $orderStatusClass = match (strtolower($order->order_status)) {
                            'completed' => 'completed',
                            'cancelled' => 'cancelled',
                            'processing' => 'processing',
                            default => 'pending'
                        };
                        $paymentStatusClass = match (strtolower($order->payment_status)) {
                            'paid' => 'paid',
                            'failed' => 'failed',
                            default => 'pending'
                        };
                    @endphp
                    <span class="status-badge {{ $orderStatusClass }}">
                        <i class="bi bi-box-seam"></i> {{ ucfirst($order->order_status) }}
                    </span>
                    <span class="status-badge {{ $paymentStatusClass }}">
                        <i class="bi bi-credit-card"></i> {{ ucfirst($order->payment_status) }}
                    </span>
                </div>
            </div>

            <div class="row g-4">

                {{-- Left Column --}}
                <div class="col-lg-8">

                    {{-- Order Items --}}
                    <div class="detail-card">
                        <div class="card-header-custom">
                            <!-- <div class="header-icon bg-primary bg-opacity-10 text-primary">
                       <i class="fa-solid fa-info"></i>
                    </div> -->
                            <h5>Order Items</h5>
                        </div>

                        <div style="overflow-x: auto;">
                            <table class="items-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product</th>
                                        <th>Type</th>
                                        <th>Price</th>
                                        <th>Qty</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($order->order_details ?? [] as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                <div class="product-info-cell">
                                                    @if(isset($item->product))
                                                        @if($item->product->type === 'image' && $item->product->mid_path)
                                                            <img src="{{ Storage::disk('s3')->url($item->product->mid_path) }}"
                                                                class="product-thumb" alt="">
                                                        @elseif($item->product->type === 'video' && $item->product->thumbnail_path)
                                                            <img src="{{ Storage::disk('s3')->url($item->product->thumbnail_path) }}"
                                                                class="product-thumb" alt="">
                                                        @else
                                                            <img src="{{ asset('assets/admin/images/demo_thumbnail.png') }}"
                                                                class="product-thumb" alt="">
                                                        @endif
                                                        <div>
                                                            <div class="product-title">{{ $item->product->title ?? 'N/A' }}
                                                            </div>
                                                            <div class="product-type">{{ ucfirst($item->product->type ?? '') }}
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="product-title">Product Deleted</div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <span
                                                    class="status-badge {{ $item->product->type === 'image' ? 'processing' : 'pending' }}">
                                                    {{ ucfirst($item->product->type ?? 'N/A') }}
                                                </span>
                                            </td>
                                            <td>${{ number_format($item->price ?? 0, 2) }}</td>
                                            <td>{{ $item->quantity ?? 1 }}</td>
                                            <td><strong>${{ number_format(($item->price ?? 0) * ($item->quantity ?? 1), 2) }}</strong>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">No items found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- Total --}}
                        <div class="total-section">
                            <div class="total-breakdown">
                                <div class="total-row">
                                    <span>Subtotal</span>
                                    <span>${{ number_format($order->total_amount, 2) }}</span>
                                </div>
                                <div class="total-row">
                                    <span>Tax</span>
                                    <span>$0.00</span>
                                </div>
                                <div class="total-row grand-total">
                                    <span>Total</span>
                                    <span>${{ number_format($order->total_amount, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Right Column --}}
                <div class="col-lg-4">

                    {{-- Customer Info --}}
                    <div class="detail-card">
                        <div class="card-header-custom">
                            <div class="header-icon bg-success bg-opacity-10 text-success">
                                <i class="fa-solid fa-address-book"></i>
                            </div>
                            <h6>Customer Info</h6>
                        </div>
                        <div class="card-body-custom">
                            <div class="info-grid">
                                <div class="info-item">
                                    <label>Full Name</label>
                                    <div class="info-value">
                                        {{ $order->user->first_name . ' ' . $order->user->last_name ?? 'N/A' }}</div>
                                </div>
                                <div class="info-item">
                                    <label>Email</label>
                                    <div class="info-value" style="word-break: break-all;">{{ $order->email }}</div>
                                </div>
                                @if($order->user)
                                        <div class="info-item">
                                            <label>Member Since</label>
                                            <div class="info-value">{{ $order->user->created_at->format('d M Y') }}</div>
                                        </div>
                                        <!-- <div class="info-item">
                                        <label>User ID</label>
                                        <div class="info-value">#{{ $order->user->id }}</div>
                                    </div> -->
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Payment Info --}}
                    <div class="detail-card">
                        <div class="card-header-custom">
                            <div class="header-icon bg-warning bg-opacity-10 text-warning">
                                <i class="fa-brands fa-amazon-pay"></i>
                            </div>
                            <h6>Payment Info</h6>
                        </div>
                        <div class="card-body-custom">
                            <div class="info-grid">
                                <div class="info-item">
                                    <label>Order Number</label>
                                    <div class="info-value">{{ $order->order_number }}</div>
                                </div>
                                <div class="info-item">
                                    <label>Total Amount</label>
                                    <div class="info-value" style="font-size: 16px; font-weight: 700; color: #1e293b;">
                                        ${{ number_format($order->total_amount, 2) }}
                                    </div>
                                </div>
                                <div class="info-item">
                                    <label>Payment Status</label>
                                    <div class="info-value">
                                        <span class="status-badge {{ $paymentStatusClass }}">
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="info-item">
                                    <label>Order Status</label>
                                    <div class="info-value">
                                        <span class="status-badge {{ $orderStatusClass }}">
                                            {{ ucfirst($order->order_status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Order Timeline --}}
                    <!-- <div class="detail-card">
                        <div class="card-header-custom">
                            <div class="header-icon bg-info bg-opacity-10 text-info">
                                <i class="bi bi-clock-history"></i>
                            </div>
                            <h6>Order Timeline</h6>
                        </div>
                        <div class="card-body-custom">
                            <div class="timeline">
                                <div class="timeline-item">
                                    <div class="timeline-dot success"></div>
                                    <div class="tl-title">Order Placed</div>
                                    <div class="tl-time">{{ $order->created_at->format('d M Y, h:i A') }}</div>
                                </div>

                                @if($order->payment_status === 'paid')
                                    <div class="timeline-item">
                                        <div class="timeline-dot success"></div>
                                        <div class="tl-title">Payment Received</div>
                                        <div class="tl-time">{{ $order->updated_at->format('d M Y, h:i A') }}</div>
                                    </div>
                                @elseif($order->payment_status === 'failed')
                                    <div class="timeline-item">
                                        <div class="timeline-dot danger"></div>
                                        <div class="tl-title">Payment Failed</div>
                                        <div class="tl-time">{{ $order->updated_at->format('d M Y, h:i A') }}</div>
                                    </div>
                                @else
                                    <div class="timeline-item">
                                        <div class="timeline-dot active"></div>
                                        <div class="tl-title">Awaiting Payment</div>
                                        <div class="tl-time">Pending</div>
                                    </div>
                                @endif

                                @if($order->order_status === 'processing')
                                    <div class="timeline-item">
                                        <div class="timeline-dot active"></div>
                                        <div class="tl-title">Processing</div>
                                        <div class="tl-time">In Progress</div>
                                    </div>
                                @elseif($order->order_status === 'completed')
                                    <div class="timeline-item">
                                        <div class="timeline-dot success"></div>
                                        <div class="tl-title">Order Completed</div>
                                        <div class="tl-time">{{ $order->updated_at->format('d M Y, h:i A') }}</div>
                                    </div>
                                @elseif($order->order_status === 'cancelled')
                                    <div class="timeline-item">
                                        <div class="timeline-dot danger"></div>
                                        <div class="tl-title">Order Cancelled</div>
                                        <div class="tl-time">{{ $order->updated_at->format('d M Y, h:i A') }}</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div> -->

                </div>
            </div>
        </div>
    </div>
</div>