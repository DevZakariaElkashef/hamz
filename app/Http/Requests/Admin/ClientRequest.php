<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClientRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $required = match ($this->id) {
            null => 'required',
            default => 'nullable',
        };

        return [
            'name' => 'required|string|max:255',
            'email' => [
                'nullable',
                Rule::unique('users')->ignore($this->id),
            ],
            'phone' => [
                'required',
                Rule::unique('users')->ignore($this->id),
            ],
            'password' => $required . '|min:8|max:255',
            'city_id' => 'nullable|exists:cities,id',
            'image' => 'nullable|mimes:png,jpg,jpeg',
            'is_active' => 'required|boolean',

        ];
    }
}
