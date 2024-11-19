<?php

namespace App\Exports\Mall;

use App\Models\Section;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SectionExport implements FromCollection, WithHeadings, ShouldAutoSize
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

        return Section::filter($this->request)->mall()->get()->map(function ($section) {
            return [
                'id' => $section->id,
                'name' => $section->name,
                'status' => $section->is_active ? __("main.active") : __("main.not_active"),
                'created_at' => $section->created_at->format('Y-m-d H:i:s'),
            ];
        });
    }


    public function headings(): array
    {
        return [
            __("main.id"),
            __("main.name"),
            __("main.status"),
            __("main.date")
        ];
    }
}
