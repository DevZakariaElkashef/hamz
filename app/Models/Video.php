<?php

namespace App\Models;

use App\Traits\ActiveScope;
use App\Traits\AppScope;
use App\Traits\FilterScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
    use HasFactory, AppScope, ActiveScope, FilterScope, SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function viewed()
    {
        return $this->hasMany(View::class)->where('status', '1');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function getTitleAttribute()
    {
        return $this->attributes['title_' . app()->getLocale()];
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('title_ar', 'like', "%$search%")->orWhere('title_en', 'like', "%$search%")->orWhereHas('category', function($category) use($search) {
            $category->where('name_ar', 'like', "%$search%")->orWhere('name_en', 'like', "%$search%");
        });
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
