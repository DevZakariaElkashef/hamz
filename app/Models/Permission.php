<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use HasFactory,  SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function scopeStores($query)
    {
        return $query->where('app', 'stores');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permission')->withTimestamps();
    }
}
