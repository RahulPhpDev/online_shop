<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\WithAndWhereHas;

class Product extends Model
{
    use SoftDeletes, WithAndWhereHas;

    protected $fillable = [
        'product_uuid',
        'name',
        'slug',
        'description',
        'unit_id',
        'is_popular',
        'price',
        'available',
        'feature'
    ];

    protected $appends = ['is_my_fav'];
  
    protected $with = ['unit'];

    protected $casts = [
        'feature' => 'array'
    ]; 

    /**
     * @param $query
     * @return mixed
     */
    public function scopePopular($query)
    {
        return $query->where('is_popular', 1);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeAllTimeAvailable($query)
    {
        return $query->where('available', 1);
    }
    /**
 * Get the route key for the model.
 *
 * @return string
 */
    public function getRouteKeyName()
    {
        return 'product_uuid';
    }

    public function getIsMyFavAttribute()
    {
        if (! \Auth::check() ) return false;
       return  $this->isMyFavProduct() ;
    }
    /**
     * @return BelongsTo
     */
    public function unit() : BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    /**
     * @return HasOne
     */
    public function inventory() : HasOne
    {
        return $this->hasOne(Inventory::class);
    }

    public function setFeatureAttribute($values)
    {
        $feature = [];
        foreach($values as $key => $value) {
            if (!is_null($key) && !is_null($value) ) {
                $feature[$key] = $value;
            }
        }
        $this->attributes['feature'] = json_encode($feature);
    }

    public function imageable()
    {
        return $this->morphMany(Image::class , 'imageable');
    }

    public function favouriteProduct()
    {
        return $this->belongsToMany(User::class, 'user_favourite_product')->where('user_id', \Auth::id());
    }

    public function isMyFavProduct()
    {
          return $this->belongsToMany(User::class, 'user_favourite_product')->exists();
    }
}
