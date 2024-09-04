<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class SectionExport implements FromCollection
{
    public $request;

    public function __construct($request)
    {
        $this->request = $request;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        
    }
}
