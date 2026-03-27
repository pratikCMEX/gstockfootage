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
            text-align: center;
            font-size: 11px;
        }
        td { padding: 6px; border-bottom: 1px solid #eee; font-size: 10px;    text-align: center; }
        tr:nth-child(even) td { background: #f9f9f9; }
        .badge-success { color: #198754; font-weight: bold; }
        .badge-warning { color: #fd7e14; font-weight: bold; }
        .badge-danger  { color: #dc3545; font-weight: bold; }
        .badge-info    { color: #0dcaf0; font-weight: bold; }
        .footer { text-align: right; margin-top: 10px; font-size: 9px; color: #999; }
        .summary { margin-bottom: 15px; padding: 8px; background: #fff3e0; border-left: 3px solid #fd7e14; }
        .summary span { margin-right: 20px; }
         .report-footer {
            margin-top: 15px !important;
            text-align: right;
            font-size: 10px;
            color: #aaa;
             margin: 0 30px;
        }
          .report-header {
            margin-top: 40px;
            margin-bottom: 30px;
            text-align: center;
        }

        .report-header h2 {
            font-size: 20px;
            font-weight: bold;
            color: #111;
            margin-bottom: 6px;
        }
           .table-wrapper {
            margin: 0 30px;
        }
    </style>
</head>
<body>
    <div class="report-header">
    <h2>Live Cart Report</h2>
    <p class="subtitle">Generated on {{ now()->format('d M Y, h:i A') }}</p>
</div>
   
<div class="table-wrapper">
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
    </div>

    <div class="report-footer">
        Total {{ $carts->count() }} record(s) exported
    </div>
</body>
</html>