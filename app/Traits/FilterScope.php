<?php

namespace App\Traits;

trait FilterScope
{
    public function scopeFilter($query, $request)
    {
        if ($request->filled('start_at')) {
            $query->whereDate('created_at', '>=', $request->start_at);
        }

        if ($request->filled('end_at')) {
            $query->whereDate('created_at', '<=', $request->end_at);
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        if ($request->filled('store_id')) {
            $query->where('store_id', $request->store_id);
        }

        if ($request->filled('section_id')) {
            $query->where('section_id', $request->section_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('attribute_id')) {
            $query->where('attribute_id', $request->attribute_id);
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        if ($request->filled('product_section_id')) {
            $query->whereHas('store', function ($store) use ($request) {
                $store->where('section_id', $request->product_section_id);
            });
        }

        if ($request->filled('product_store_id')) {
            $query->whereHas('store', function ($query) use ($request) {
                $query->where('stores.id', $request->product_store_id);
            });
        }

        if ($request->filled('order_section_id')) {
            $query->whereHas('store', function ($store) use ($request) {
                $store->where('section_id', $request->order_section_id);
            });
        }

        return $query;
    }
}
