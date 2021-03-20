<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

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
}
