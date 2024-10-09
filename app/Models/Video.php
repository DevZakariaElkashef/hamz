<?php

namespace App\Models;

use App\Traits\ActiveScope;
use App\Traits\AppScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
    use HasFactory, AppScope, ActiveScope, SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function viewed()
    {
        return $this->hasMany(View::class);
    }

    // Define this method as a scope
    public function scopeApplyUserViewFilters($query, $request)
    {
        return $query->where(function ($q) use ($request) {
            $q->whereDoesntHave('viewed', function ($query) use ($request) {
                $query->where('user_id', $request->user()->id);
            })->orWhereHas('viewed', function ($view) use ($request) {
                $view->where('user_id', $request->user()->id)->where('status', 0);
            });
        });
    }

    public function scopeNextVideo($query, $request)
    {
        return $query->earn()
            ->active()
            ->applyUserViewFilters($request)
            ->first();
    }

    public function scopeFilterVideos($query, $request)
    {
        return $query->earn()
            ->active()
            ->applyUserViewFilters($request)
            ->when($request->category_id, function ($query) use ($request) {
                $query->where('category_id', $request->category_id);
            });
    }
}
