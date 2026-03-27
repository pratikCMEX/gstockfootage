 <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Email</th>
                <th>Order Number</th>
                <th>Total Amount ($)</th>
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
                    <td>{{ number_format($order->total_amount, 2) }}</td>
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