<?php

namespace App\Http\Requests\Booth\Web;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'description_ar' => 'required|string|max:60000',
            'description_en' => 'required|string|max:60000',
            'phone' => [
                'required',
                Rule::unique('stores')->ignore($this->id)->whereNull('deleted_at'),
            ],
            'section_id' => 'required|exists:sections,id',
            'city_id' => 'required|exists:cities,id',
            'user_id' => [
                'required',
                'exists:users,id',
                Rule::unique('stores', 'user_id')->where(function ($query) {
                    return $query->where('app', 'booth')->whereNull('deleted_at');
                })->ignore($this->id),
            ],
            'lat' => 'required|string|max:255',
            'lng' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'is_active' => 'required|boolean',
            'image' => 'nullable|mimes:png,jpg,jpeg',
            'images.*' => 'nullable|mimes:png,jpg,jpeg',
            'pick_up' => 'nullable|boolean',
            'delivery_type' => 'nullable|boolean',
        ];
    }
}
