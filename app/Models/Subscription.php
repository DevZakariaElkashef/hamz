<?php

namespace App\Models;

use App\Traits\AppScope;
use App\Traits\FilterScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    use HasFactory, FilterScope, AppScope, SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function video()
    {
        return $this->belongsTo(Video::class);
    }

    public function scopeSearch($query, $search)
    {
        return $query->whereHas('user', function ($user) use ($search) {
            $user->where('name', 'LIKE', "%$search%")
                ->orWhere('phone', 'LIKE', "%$search%");
        })->orWhereHas('package', function ($package) use ($search) {
            $package->where('name_ar', 'LIKE', "%$search%")
                ->orWhere('name_en', 'LIKE', "%$search%");
        });
    }

    public function getStatusNameAttribute()
    {
        $status = $this->attributes['status'];
        switch ($status) {
            case '0':
                return __("main.pending");
            case '1':
                return __("main.active");
            case '2':
                return __("main.expired");
            case '3':
                return __("main.cancelled");
            default:
                return __('main.unknown');
        }
    }
}
