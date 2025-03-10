<?php

namespace App\Http\Requests\Earn\Web;

use Illuminate\Foundation\Http\FormRequest;

class VideoRequest extends FormRequest
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
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'duration' => 'required',
            // 'reword_amount' => 'required',
            'thumbnail' => 'nullable|file|mimes:png,jpg,jpeg',
            'path' => 'required|url',
            'store_url' => 'nullable|url|required_without:store_id',
            'store_id' => 'nullable|integer|required_without:store_url',
            // 'package_id' => 'required|integer',
            // 'is_active' => 'required|boolean'
        ];
    }
}
