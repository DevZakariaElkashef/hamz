<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Withdrow extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];


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
