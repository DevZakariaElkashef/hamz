<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ClientExport implements FromCollection, WithHeadings, ShouldAutoSize
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
        return User::filter($this->request)->with('city')->where('role_id', 2)->get()->map(function ($brand) {
            return [
                'id' => $brand->id,
                'name' => $brand->name,
                'phone' => $brand->phone,
                'email' => $brand->email,
                'city' => $brand->city->name ?? '',
                'wallet' => $brand->wallet,
                'status' => $brand->is_active ? __("main.active") : __("main.not_active"),
                'date' => $brand->created_at->format('Y-m-d'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            __('main.id'),
            __('main.name'),
            __('main.phone'),
            __('main.email'),
            __('main.city'),
            __('main.wallet'),
            __('main.status'),
            __('main.date'),
        ];
    }
}
