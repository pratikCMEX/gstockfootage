<!DOCTYPE html>
<html>
<head>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: sans-serif; font-size: 11px; color: #333; }
        h2 { text-align: center; margin-bottom: 5px; font-size: 16px; }
        .subtitle { text-align: center; color: #666; margin-bottom: 15px; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th {
            background: #fd7e14;
            color: #fff;
            padding: 7px 6px;
            text-align: left;
            font-size: 11px;
        }
        td { padding: 6px; border-bottom: 1px solid #eee; font-size: 10px; }
        tr:nth-child(even) td { background: #f9f9f9; }
        .badge-success { color: #198754; font-weight: bold; }
        .badge-warning { color: #fd7e14; font-weight: bold; }
        .badge-danger  { color: #dc3545; font-weight: bold; }
        .badge-info    { color: #0dcaf0; font-weight: bold; }
        .footer { text-align: right; margin-top: 10px; font-size: 9px; color: #999; }
        .summary { margin-bottom: 15px; padding: 8px; background: #fff3e0; border-left: 3px solid #fd7e14; }
        .summary span { margin-right: 20px; }
    </style>
</head>
<body>
    <h2>Order History</h2>
    <p class="subtitle">Generated on {{ now()->timezone('Asia/Kolkata')->format('d M Y, h:i A') }}</p>

    {{-- Summary --}}
    <!-- <div class="summary">
        <span>Total Orders: <strong>{{ $orders->count() }}</strong></span>
        <span>Total Amount: <strong>${{ number_format($orders->sum('total_amount'), 2) }}</strong></span>
        <span>Completed: <strong>{{ $orders->where('order_status', 'completed')->count() }}</strong></span>
        <span>Pending: <strong>{{ $orders->where('order_status', 'pending')->count() }}</strong></span>
    </div> -->

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Email</th>
                <th>Order Number</th>
                <th>Total Amount</th>
                <th>Order Status</th>
                <th>Payment Status</th>
                <th>Created Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $index => $order)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $order->user->email ?? '-' }}</td>
                <td>{{ $order->order_number }}</td>
                <td>${{ number_format($order->total_amount, 2) }}</td>
                <td>
                    @if($order->order_status === 'completed')
                        <span class="badge-success">Completed</span>
                    @elseif($order->order_status === 'pending')
                        <span class="badge-warning">Pending</span>
                    @elseif($order->order_status === 'cancelled')
                        <span class="badge-danger">Cancelled</span>
                    @else
                        <span class="badge-info">{{ ucfirst($order->order_status) }}</span>
                    @endif
                </td>
                <td>
                    @if($order->payment_status === 'paid')
                        <span class="badge-success">Paid</span>
                    @elseif($order->payment_status === 'pending')
                        <span class="badge-warning">Pending</span>
                    @elseif($order->payment_status === 'failed')
                        <span class="badge-danger">Failed</span>
                    @else
                        {{ ucfirst($order->payment_status) }}
                    @endif
                </td>
                <td>{{ $order->created_at->format('d M Y, h:i A') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center; padding:15px;">No records found</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Total {{ $orders->count() }} record(s) exported
    </div>
</body>
</html>