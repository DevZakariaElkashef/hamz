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

    return $query;
  }
}
