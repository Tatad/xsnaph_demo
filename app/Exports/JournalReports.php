<?php

namespace App\Exports;

use App\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class JournalReports implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $journals;

    public function __construct(array $journals)
    {
        $this->journals = $journals;
    }

    public function array(): array
    {
        return $this->journals;
    }

    public function view(): View
    {
        //dd($this->journals);
        return view('exports.journal-reports', [
            'journals' => $this->journals
        ]);
    }

    public function collection()
    {
        return User::all();
    }
}
