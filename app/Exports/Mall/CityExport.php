<?php

namespace App\Exports\Mall;

use App\Models\City;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CityExport implements FromCollection, WithHeadings, ShouldAutoSize
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
        return City::filter($this->request)->mall()->get()->map(function ($city) {
            return [
                'id' => $city->id,
                'name' => $city->name,
                'status' => $city->is_active ? __("main.active") : __("main.not_active"),
                'date' => $city->created_at->toDateTimeString(),
            ];
        });
    }


    public function headings(): array
    {
        return [
            __("main.id"),
            __('main.name'),
            __('main.status'),
            __('main.date'),
        ];
    }
}
