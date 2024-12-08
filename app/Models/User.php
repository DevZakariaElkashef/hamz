<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\ActiveScope;
use App\Traits\FilterScope;
use App\Traits\ImageAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, FilterScope, ActiveScope, ImageAttribute, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed'
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function hasPermission($permission)
    {
        return $this->role && $this->role->permissions->contains('name', $permission);
    }

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function favourites()
    {
        return $this->hasMany(Favourite::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function viewes()
    {
        return $this->hasMany(View::class);
    }

    public function withdrows()
    {
        return $this->hasMany(Withdrow::class);
    }

    public function store()
    {
        return $this->hasOne(Store::class);
    }

    public function advertisercharacter()
    {
        return $this->belongsTo(AdvertiserCharacter::class, 'advertisercharacter_id');
    }
}
