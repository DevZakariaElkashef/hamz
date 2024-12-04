<?php

namespace App\Http\Requests\rfoof\Socials;

use App\Models\Social;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSocialRequest extends FormRequest
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
            'link' => 'required|url',
            'icon' => 'nullable',
            'social_id' => 'required|exists:socials,id',
        ];
    }
}
