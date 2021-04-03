<?php

namespace App;

use App\Enums\RoleEnums;
use App\Models\Product;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Models\Traits\WithAndWhereHas;

class User extends Authenticatable
{
    use HasApiTokens,Notifiable, WithAndWhereHas;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','phone', 'role_id','country_code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeAdmins($query)
    {
        return $query->where('role_id', RoleEnums::ADMIN);
    }

    
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function scopeLoginUser($query) 
    {
        // dd( $query->findOrFail(\Auth::id()) );
        return $query->findOrFail(\Auth::id() );
    }

    public function favouriteProduct()
    {
        return $this->belongsToMany(Product::class, 'user_favourite_product');
        // ->where('user_id', \Auth::id());
    }
}
