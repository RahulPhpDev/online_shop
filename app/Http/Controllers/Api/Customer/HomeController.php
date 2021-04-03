<?php

namespace App\Http\Controllers\Api\Customer;

use App\Enums\PaginationEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Admin\BannerResource;
use App\Http\Resources\Api\Admin\ProductResource;
use App\Http\Resources\Api\Admin\ProductResourceCollection;
use App\Http\Resources\Api\Admin\SiteContentResource;
use App\Http\Resources\Api\Customer\BannerResourceCollection;
use App\Http\Resources\Api\Customer\EmptyResource;
use App\Http\Resources\Api\Customer\HomeResourceCollection;
use App\Http\Resources\Api\Customer\SiteResourceCollection;
use App\Models\Banner;
use App\Models\Cart;
use App\Models\Coupen;
use App\Models\Order;
use App\Models\Product;
use App\Models\SiteContent;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
class HomeController extends Controller
{
  

	public function index()
	{
		
			$siteContent = SiteContent::toBase()->get();
			$banner = Banner::query()->with('imageable')->get();
			$product = Product::query()->with('imageable')->get();
			$carts = Cart::with('cartProducts')->first();
			$orders = Order::user()->with('product')->latest()->get();
			$coupen = Coupen::query()->get();
			$output = Arr::add(
				[	
					'page' => $siteContent,
					'banner'=> $banner,
					'cart' => $carts,
					'orders' => $orders,
					'coupen' => $coupen,
					'unread_notification' => \Auth::user()->unreadNotifications
				],
				'product' , $product
			);
			return new HomeResourceCollection($output);
			return response()->json(['result' => 1,'msg' => 'success','data' => $output]);
	}


    public function siteContent($id = null)
    {
    	$siteContent = SiteContent::paginate(PaginationEnum::CommonPagination);
   	   return  new SiteResourceCollection($siteContent);
    }

    public function show(Request $request)
    {
    	try {
			$siteContent = SiteContent::query()->where('slug', $request->slug)->firstOrFail();
			return  new SiteContentResource($siteContent);
    	} catch (\Exception $e) 
    	{
  			return new EmptyResource();
    	}
    }

    public function banner()
    {
		$records = Banner::query()->with('imageable')->paginate(PaginationEnum::CommonPagination);
   	   return new BannerResourceCollection($records);
   
    }

    public function showBanner(Request $request)
    {

		try {
			$records = Banner::query()
						->where('slug', $request->slug)
						->with('imageable')->firstOrFail();
   		   return BannerResourceCollection::collection($records);
		}
		catch(\Exception $e)
		{
			return new EmptyResource();
		}
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
