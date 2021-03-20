<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
class Address extends Model
{
    protected $fillable = [
        'house_no',
        'street',
        'state',
        'district',
        'pin_code',
        'landmark',
        'type',
    ];

    protected $casts = [
        'type' => 'integer',

    ];

    protected static function booted()
    {
        static::addGlobalScope('user_address', function ($query) {
            $query->with(['user' => function ($subQuery) {
                return $subQuery->whereUserId(Auth::id());
            }]);
        });
        static::deleting( function ($address) {
            $address->user()->detach(Auth::id());
        });
    }
    public function user()
    {
        return $this->belongsToMany(User::class, 'user_address');
    }
}
