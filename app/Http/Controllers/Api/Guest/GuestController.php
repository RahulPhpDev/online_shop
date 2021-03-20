<?php

namespace App\Http\Controllers\Api\Guest;

use App\Enums\PaginationEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Admin\BannerResource;
use App\Http\Resources\Api\Admin\ProductResource;
use App\Http\Resources\Api\Admin\ProductResourceCollection;
use App\Http\Resources\Api\Admin\SiteContentResource;
use App\Models\Banner;
use App\Models\Product;
use App\Models\SiteContent;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function testing($string = 'fasd dfsd')
    {
             $pipes = [
                    \App\PipeLines\RemoveProductFromCart::class,
                ];

                $goodString = app(\Illuminate\Pipeline\Pipeline::class)
                        ->send($string)
                        ->through($pipes)
                        ->thenReturn();
                        dd($goodString);
    }


    public function siteContent($id = null)
    {
    	$siteContent = SiteContent::query();
    	$siteContent->when($id, function ($query) use ($id) {
			$query->findOrFail($id);
    	}, function ($query) {
    		$query->paginate(PaginationEnum::CommonPagination);
    	} );

   	   return SiteContentResource::collection($siteContent->get());
    }

    public function banner($id = null)
    {
		$records = Banner::query();
    	$records->when($id, function ($query) use ($id) {
			$query->findOrFail($id);
    	}, function ($query) {
    		$query->paginate(PaginationEnum::CommonPagination);
    	} );
   	   return BannerResource::collection($records->with('imageable')->get());
    }

    public function product($id = null)
    {
		$records = Product::query();
    	return $records->when($id, function ($query) use ($id) {
				$rec = $query->with('imageable')->findOrFail($id);
				return new ProductResource($rec);
	    	}, function ($query) {
	    		$rec = $query->with('imageable')->paginate(PaginationEnum::CommonPagination);
				return new ProductResourceCollection($rec);
    		} );
    }



}
