<?php

namespace App\Http\Requests\usedMarket\Settings;

use Illuminate\Foundation\Http\FormRequest;

class AddSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name_ar' => 'required|string|max:250',
            'phone' => 'required|string|max:50',
            'email' => 'required|string|email:filter|max:250',
            'firebase' => 'required',
            'logo' => 'nullable|mimes:png,jpg,jpeg,webp,ico',
        ];
    }
}
