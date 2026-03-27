   <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Product Name</th>
                <th>Category Name</th>
                <th>Total Views</th>
               
            </tr>
        </thead>
        <tbody>
            @forelse($products as $index => $data)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $data->title }}</td>
                <td>{{ $data->category->category_name ?? $data->category->category_name  }}</td>
                <td>{{ $data->views }}</td>
               
               
               
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align:center; padding:15px;">No records found</td>
            </tr>
            @endforelse
        </tbody>
    </table>