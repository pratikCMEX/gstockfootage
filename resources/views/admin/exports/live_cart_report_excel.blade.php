
    <table>
        <thead>
            <tr>
                <th>Sr. No.</th>
                <th>User Name</th>
                <th>Product Name</th>
                <th>Total Items</th>
                <th>Total Amount ($)</th>
                <th>Date</th>
               
            </tr>
        </thead>
        <tbody>
            @forelse($carts as $index => $data)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $data->user ? $data->user->first_name.' '.$data->user->last_name : '-'  }}</td>
                <td>{{ $data->product ? $data->product->title : '-'  }}</td>
                <td>{{ $data->qty }}</td>
                <td>{{ $data->qty * ($data->product->price ?? 0) }}</td>
                <td>{{ $data->created_at ? $data->created_at->format('d M Y, h:i A') : '-'  }}</td>
               
               
               
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align:center; padding:15px;">No records found</td>
            </tr>
            @endforelse
        </tbody>
    </table>