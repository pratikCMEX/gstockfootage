
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Product Name</th>
            <th>Category</th>
            <th>Type</th>
            <th>Price ($)</th>
            <th>Total Orders</th>
            <th>Total Revenue ($)</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $index => $product)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $product->title ?? '-' }}</td>
            <td>{{ $product->category->category_name ?? '-' }}</td>
            <td>{{ ucfirst($product->type ?? '-') }}</td>
            <td>{{ number_format($product->price, 2) }}</td>
            <td>{{ $product->total_orders }}</td>
            <td>{{ number_format($product->total_revenue, 2) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>