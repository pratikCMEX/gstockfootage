<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SubscriptionReportExport implements FromView, WithTitle, ShouldAutoSize, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $subscriptions;

    public function __construct($subscriptions)
    {
        $this->subscriptions = $subscriptions;
    }

    public function view(): View
    {
        return view('admin.exports.subscription_report_excel', [
            'subscriptions' => $this->subscriptions,
        ]);
    }

    public function title(): string
    {
        return 'User Subscription Report';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style header row bold
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}
