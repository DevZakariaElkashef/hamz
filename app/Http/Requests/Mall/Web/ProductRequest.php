<?php

namespace App\Http\Requests\Mall\Web;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'description_ar' => 'required|string',
            'description_en' => 'required|string',
            'price' => 'required|numeric|gt:0',
            'offer' => 'nullable|numeric', // Assuming offer is a percentage
            'start_offer_date' => 'nullable|date|after_or_equal:today',
            'end_offer_date' => 'nullable|date|after_or_equal:start_offer_date',
            'qty' => 'required|integer|min:0',
            'section_id' => 'required|exists:sections,id',
            'store_id' => 'required|exists:stores,id',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'is_active' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'images.*' => 'nullable|mimes:png,jpg,jpeg|max:2048',
            'attributes.*' => 'nullable|exists:attributes,id',
            'options.*' => 'nullable|exists:options,id',
            'costs.*' => 'nullable|numeric'
        ];
    }


    public function messages(): array
{
    return [
        '_token.required' => __('main.token_required'),
        'name_ar.required' => __('main.name_ar_required'),
        'name_ar.string' => __('main.name_ar_string'),
        'name_ar.max' => __('main.name_ar_max'),

        'name_en.required' => __('main.name_en_required'),
        'name_en.string' => __('main.name_en_string'),
        'name_en.max' => __('main.name_en_max'),

        'description_ar.required' => __('main.description_ar_required'),
        'description_ar.string' => __('main.description_ar_string'),

        'description_en.required' => __('main.description_en_required'),
        'description_en.string' => __('main.description_en_string'),

        'price.required' => __('main.price_required'),
        'price.numeric' => __('main.price_numeric'),
        'price.min' => __('main.price_min'),

        'offer.numeric' => __('main.offer_numeric'),
        'offer.min' => __('main.offer_min'),
        'offer.max' => __('main.offer_max'),

        'start_offer_date.required' => __('main.start_offer_date_required'),
        'start_offer_date.date' => __('main.start_offer_date_date'),
        'start_offer_date.after_or_equal' => __('main.start_offer_date_after_or_equal'),

        'end_offer_date.required' => __('main.end_offer_date_required'),
        'end_offer_date.date' => __('main.end_offer_date_date'),
        'end_offer_date.after' => __('main.end_offer_date_after'),

        'qty.required' => __('main.qty_required'),
        'qty.integer' => __('main.qty_integer'),
        'qty.min' => __('main.qty_min'),

        'section_id.required' => __('main.section_id_required'),
        'section_id.exists' => __('main.section_id_exists'),

        'store_id.required' => __('main.store_id_required'),
        'store_id.exists' => __('main.store_id_exists'),

        'category_id.required' => __('main.category_id_required'),
        'category_id.exists' => __('main.category_id_exists'),

        'brand_id.required' => __('main.brand_id_required'),
        'brand_id.exists' => __('main.brand_id_exists'),

        'is_active.required' => __('main.is_active_required'),
        'is_active.boolean' => __('main.is_active_boolean'),

        'image.image' => __('main.image_image'),
        'image.mimes' => __('main.image_mimes'),
        'image.max' => __('main.image_max'),
    ];
}

}
