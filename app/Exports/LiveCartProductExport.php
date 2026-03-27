<?php

namespace App\Exports;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\FromCollection;

class LiveCartProductExport implements  FromView, WithTitle, ShouldAutoSize, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
     protected $carts;

    public function __construct($carts)
    {
        $this->carts = $carts;
    }

    public function view(): View
    {
        return view('admin.exports.live_cart_report_excel', [
            'carts' => $this->carts,
        ]);
    }

    public function title(): string
    {
        return 'Live Cart Report';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style header row bold
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}
