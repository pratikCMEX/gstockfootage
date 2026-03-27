<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
class UserWiseOrdersExport implements FromView, WithTitle, ShouldAutoSize, WithStyles
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
        return view('admin.exports.user_wise_orders_excel', [
            'orders' => $this->orders,
        ]);
    }

    public function title(): string
    {
        return 'User Wise Order Report';
    }

    public function styles(Worksheet $sheet)
    {
        // Get highest row & column dynamically
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        // Apply center alignment to ALL cells
        $sheet->getStyle('A1:' . $highestColumn . $highestRow)
            ->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        // Optional: Bold header row
        $sheet->getStyle('A1:' . $highestColumn . '1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
            ],
        ]);

        return [];
    }
    // public function styles(Worksheet $sheet)
    // {
    //     return [
    //         // Style header row bold
    //         1 => ['font' => ['bold' => true, 'size' => 12]],
    //     ];
    // }
}
