<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'src'
    ];

    public function getRouteKeyName()
    {
    	return 'slug';
    }

    public function imageable()
    {
       return $this->morphMany(Image::class, 'imageable');
    }
}
