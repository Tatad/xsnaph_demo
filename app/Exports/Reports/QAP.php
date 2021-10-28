<?php

namespace App\Exports\Reports;

use App\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class QAP implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        return $this->data;
    }

    public function view(): View
    {
        return view('exports.reports.qap', [
            'data' => $this->data
        ]);
    }

    public function collection()
    {
        return User::all();
    }
}
