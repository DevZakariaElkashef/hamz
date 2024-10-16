<?php

namespace App\Models;

use App\Traits\AppScope;
use App\Traits\FilterScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Withdrow extends Model
{
    use HasFactory, FilterScope, SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('amount', 'like', "%$search%")
        ->orWhere('iban', 'like', "%$search%")
        ->orWhereHas('user', function($user) use($search) {
            $user->where('name', 'like', "%$search%")
                ->orWhere('phone', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%");
        });
    }

    public function getStatusNameAttribute()
    {
        $status = $this->attributes['status'];
        switch ($status) {
            case '0':
                return __("main.pending");
            case '1':
                return __("main.confirmed");
            case '2':
                return __("main.canceled");
            case '3':
                return __("main.failed");
            default:
                return __('main.unknown');
        }
    }
}
