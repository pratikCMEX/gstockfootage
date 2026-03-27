<?php

namespace App\Exports;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

use Maatwebsite\Excel\Concerns\FromCollection;

class MostViewedProductExport implements  FromView, WithTitle, ShouldAutoSize, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $products;

    public function __construct($products)
    {
        $this->products = $products;
    }

    public function view(): View
    {
        return view('admin.exports.most_viewed_report_excel', [
            'products' => $this->products,
        ]);
    }

    public function title(): string
    {
        return 'Most Sold Products';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style header row bold
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}
