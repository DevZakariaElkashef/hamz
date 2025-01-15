<?php

namespace App\Models;

use App\Traits\AppScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chat extends Model
{
    use HasFactory, AppScope, SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function checkOwner($request)
    {
        // if ($this->seller_id) {
        //     if ($this->seller_id == $request->user()->id && $this->type == "reply") {
        //         return true;
        //     } elseif ($this->user_id == $request->user()->id && $this->type == "sending") {
        //         return true;
        //     }
        //     return false;
        // } elseif ($this->user_id) {
        //     if ($this->seller_id == $request->user()->id && $this->type == "reply") {
        //         return true;
        //     } elseif ($this->user_id == $request->user()->id && $this->type == "sending") {
        //         return true;
        //     }
        //     return false;
        // }
        if($this->user_id == $request->user()->id){
            return true;
        }
        return false;
    }
}
