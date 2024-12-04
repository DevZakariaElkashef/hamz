<?php

namespace App\Http\Requests\rfoof\Product;

use App\Traits\GeneralTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateRequest extends FormRequest
{
    use GeneralTrait;
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
            'product_id' => 'required|exists:products,id',
            'name_ar' => 'nullable|string',
            'name_en' => 'nullable|string',
            'desc_ar' => 'nullable|string',
            'desc_en' => 'nullable|string',
            'price' => 'required|numeric',
            'license_number' => 'nullable',
            'images' => 'nullable|array',
            'images.*' => 'file',
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'misahuh' => 'nullable',
            'count_rooms' => 'nullable',
            'number_bathrooms' => 'nullable',
            'count_floor' => 'nullable',
            'number_councils' => 'nullable',
            'number_halls' => 'nullable',
            'street_view' => 'nullable',
            'loctaion' => 'nullable',
            'number_parties_seeking' => 'nullable',
            'width' => 'nullable',
            'height' => 'nullable',
            'floor_number' => 'nullable',
            'property_age' => 'nullable',
            'direction_id' => 'nullable|exists:directions,id',
            'lat' => 'required',
            'long' => 'required',
        ];
    }


    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator): void
    {
        $code = $this->returnCodeAccordingToInput($validator);
        throw new HttpResponseException($this->returnValidationError($code, $validator));
    }
}
