  <table>
        <thead>
            <tr>
                <th>Sr. No.</th>
                <th>Product Name</th>
                <th>Category Name</th>
                <th>Total Orders</th>
                <th>Total Revenue ($)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $index => $data)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $data->title }}</td>
                <td>{{ $data->category->category_name ?? $data->category->category_name  }}</td>
                <td>{{ $data->total_orders }}</td>
                <td>{{ number_format($data->total_revenue ?? 0, 2) }}</td>
               
               
               
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center; padding:15px;">No records found</td>
            </tr>
            @endforelse
        </tbody>
    </table>