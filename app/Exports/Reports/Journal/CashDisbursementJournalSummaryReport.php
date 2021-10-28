<?php

namespace App\Exports\Reports\Journal;

use App\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CashDisbursementJournalSummaryReport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $invoices;

    public function __construct(array $invoices)
    {
        $this->invoices = $invoices;
    }

    public function array(): array
    {
        return $this->invoices;
    }

    public function view(): View
    {
        return view('exports.reports.journals.cash-disbursement', [
            'data' => $this->invoices
        ]);
    }

    public function collection()
    {
        return User::all();
    }
}
