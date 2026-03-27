<?php
// app/Exports/MostSoldProductExport.php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MostSoldProductExport implements FromView, WithTitle, ShouldAutoSize, WithStyles
{
    protected $products;

    public function __construct($products)
    {
        $this->products = $products;
    }

    public function view(): View
    {
        return view('admin.exports.most_sold_report_excel', [
            'products' => $this->products,
        ]);
    }

    public function title(): string
    {
        return 'Most Sold Products';
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