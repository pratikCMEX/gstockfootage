  <table>
        <thead>
            <tr>
                <th>Sr. No.</th>
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