<?php

namespace App\Http\Requests\Mall\Web;

use Illuminate\Foundation\Http\FormRequest;

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
            'phone' => 'required|unique:stores,phone,' . $this->id,
            'section_id' => 'required|exists:sections,id',
            'user_id' => 'required|exists:users,id',
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
