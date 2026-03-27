  <table>
        <thead>
            <tr>
                <th>#</th>
                <th>User Name</th>
                <th>Email</th>
                <th>Total Orders</th>
                <th>Total Amount ($)</th>
                <th>Completed</th>
                <th>Pending </th>
                <th>Cancelled</th>
                <th>Last Order Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $index => $data)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $data->first_name . ' ' . $data->last_name }}</td>
                    <td>{{ $data->email }}</td>
                    <td>{{ $data->total_orders }}</td>
                    <td>{{ number_format($data->total_amount, 2) }}</td>
                    <td>{{  $data->completed_orders ?? '0'}}</td>
                    <td>{{  $data->pending_orders ?? '0'}}</td>
                    <td>{{  $data->cancelled_orders ?? '0'}}</td>
                    <td>{{ $data->last_order_date ? \Carbon\Carbon::parse($data->last_order_date)->format('d M Y') : 'N/A' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align:center; padding:15px;">No records found</td>
                </tr>
            @endforelse
        </tbody>
    </table>