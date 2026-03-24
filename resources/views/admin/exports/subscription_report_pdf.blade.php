<!DOCTYPE html>
<html>
<head>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: sans-serif; font-size: 10px; color: #333; }
        h2 { text-align: center; margin-bottom: 5px; font-size: 16px; }
        .subtitle { text-align: center; color: #666; margin-bottom: 15px; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #fd7e14; color: #fff; padding: 7px 5px; text-align: left; font-size: 10px; }
        td { padding: 5px; border-bottom: 1px solid #eee; font-size: 9px; }
        tr:nth-child(even) td { background: #f9f9f9; }
        .success { color: #198754; font-weight: bold; }
        .warning { color: #fd7e14; font-weight: bold; }
        .danger  { color: #dc3545; font-weight: bold; }
        .secondary { color: #6c757d; font-weight: bold; }
        .summary { margin-bottom: 15px; padding: 8px; background: #fff3e0; border-left: 3px solid #fd7e14; }
        .summary span { margin-right: 15px; }
        .footer { text-align: right; margin-top: 10px; font-size: 9px; color: #999; }
    </style>
</head>
<body>
    <h2>User Subscription Report</h2>
    <p class="subtitle">Generated on {{ now()->timezone('Asia/Kolkata')->format('d M Y, h:i A') }}</p>

    {{--  Summary --}}
    <!-- <div class="summary">
        <span>Total: <strong>{{ $subscriptions->count() }}</strong></span>
        <span>Active: <strong>{{ $subscriptions->where('status', 'active')->count() }}</strong></span>
        <span>Expired: <strong>{{ $subscriptions->where('status', 'expired')->count() }}</strong></span>
        <span>Cancelled: <strong>{{ $subscriptions->where('status', 'cancelled')->count() }}</strong></span>
        <span>Total Amount: <strong>{{ $subscriptions->first()->currency ?? 'USD' }} {{ number_format($subscriptions->sum('amount'), 2) }}</strong></span>
    </div> -->

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>User Name</th>
                <th>Plan</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Total Clips</th>
                <th>Used Clips</th>
                <th>Remaining</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Payment</th>
            </tr>
        </thead>
        <tbody>
            @forelse($subscriptions as $index => $sub)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $sub->user ? $sub->user->first_name . ' ' . $sub->user->last_name : 'N/A' }}</td>
                <td>{{ $sub->subscription ? $sub->subscription->name : 'N/A' }}</td>
                <td>{{ $sub->start_date ? \Carbon\Carbon::parse($sub->start_date)->format('d M Y') : 'N/A' }}</td>
                <td>{{ $sub->end_date ? \Carbon\Carbon::parse($sub->end_date)->format('d M Y') : 'N/A' }}</td>
                <td>{{ $sub->total_clips }}</td>
                <td>{{ $sub->used_clips }}</td>
                <td>{{ $sub->remaining_clips }}</td>
                <td>{{ $sub->currency }} {{ number_format($sub->amount, 2) }}</td>
                <td>
                    @if($sub->status === 'active')
                        <span class="success">Active</span>
                    @elseif($sub->status === 'expired')
                        <span class="danger">Expired</span>
                    @elseif($sub->status === 'cancelled')
                        <span class="warning">Cancelled</span>
                    @else
                        <span class="secondary">{{ ucfirst($sub->status) }}</span>
                    @endif
                </td>
                <td>
                    @if($sub->payment_status === 'success')
                        <span class="success">Success</span>
                    @elseif($sub->payment_status === 'pending')
                        <span class="warning">Pending</span>
                    @elseif($sub->payment_status === 'failed')
                        <span class="danger">Failed</span>
                    @else
                        {{ ucfirst($sub->payment_status) }}
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="11" style="text-align:center; padding:15px;">No records found</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">Total {{ $subscriptions->count() }} record(s) exported</div>
</body>
</html>