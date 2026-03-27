<?php

namespace App\Exports;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\FromCollection;

class OrderHistoryExport implements  FromView, WithTitle, ShouldAutoSize, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
   protected $orders;

    public function __construct($orders)
    {
        $this->orders = $orders;
    }

    public function view(): View
    {
        return view('admin.exports.order_history_excel', [
            'orders' => $this->orders,
        ]);
    }

    public function title(): string
    {
        return 'Order History';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style header row bold
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}
