<?php
//withAndWherehas.php
namespace App\Models\Traits;

trait withAndWherehas {

	public function scopeWithAndWhereHas($query, $relation = '', $where = null)
	{
// dd($relation ,$where);
		 // return $query->whereHas($relation, $where)
   //          ->with([$relation => $where]);
		return $query->when($where, function ($subQuery) use ($where, $relation) {
				return $subQuery->with([$relation => $where]);
		}, function ($subQuery) use ($where, $relation){
				return $subQuery->with($relation);
		}); 
	
	}
}