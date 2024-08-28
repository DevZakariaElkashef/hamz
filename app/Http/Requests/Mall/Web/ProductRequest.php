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
            'price' => 'required|numeric|min:0',
            'offer' => 'nullable|numeric|min:0|max:100', // Assuming offer is a percentage
            'start_offer_date' => 'required|date|after_or_equal:today',
            'end_offer_date' => 'required|date|after_or_equal:start_offer_date',
            'qty' => 'required|integer|min:0',
            'section_id' => 'required|exists:sections,id',
            'store_id' => 'required|exists:stores,id',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'is_active' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }


    public function messages(): array
{
    return [
        '_token.required' => __('mall.token_required'),
        'name_ar.required' => __('mall.name_ar_required'),
        'name_ar.string' => __('mall.name_ar_string'),
        'name_ar.max' => __('mall.name_ar_max'),

        'name_en.required' => __('mall.name_en_required'),
        'name_en.string' => __('mall.name_en_string'),
        'name_en.max' => __('mall.name_en_max'),

        'description_ar.required' => __('mall.description_ar_required'),
        'description_ar.string' => __('mall.description_ar_string'),

        'description_en.required' => __('mall.description_en_required'),
        'description_en.string' => __('mall.description_en_string'),

        'price.required' => __('mall.price_required'),
        'price.numeric' => __('mall.price_numeric'),
        'price.min' => __('mall.price_min'),

        'offer.numeric' => __('mall.offer_numeric'),
        'offer.min' => __('mall.offer_min'),
        'offer.max' => __('mall.offer_max'),

        'start_offer_date.required' => __('mall.start_offer_date_required'),
        'start_offer_date.date' => __('mall.start_offer_date_date'),
        'start_offer_date.after_or_equal' => __('mall.start_offer_date_after_or_equal'),

        'end_offer_date.required' => __('mall.end_offer_date_required'),
        'end_offer_date.date' => __('mall.end_offer_date_date'),
        'end_offer_date.after' => __('mall.end_offer_date_after'),

        'qty.required' => __('mall.qty_required'),
        'qty.integer' => __('mall.qty_integer'),
        'qty.min' => __('mall.qty_min'),

        'section_id.required' => __('mall.section_id_required'),
        'section_id.exists' => __('mall.section_id_exists'),

        'store_id.required' => __('mall.store_id_required'),
        'store_id.exists' => __('mall.store_id_exists'),

        'category_id.required' => __('mall.category_id_required'),
        'category_id.exists' => __('mall.category_id_exists'),

        'brand_id.required' => __('mall.brand_id_required'),
        'brand_id.exists' => __('mall.brand_id_exists'),

        'is_active.required' => __('mall.is_active_required'),
        'is_active.boolean' => __('mall.is_active_boolean'),

        'image.image' => __('mall.image_image'),
        'image.mimes' => __('mall.image_mimes'),
        'image.max' => __('mall.image_max'),
    ];
}

}
