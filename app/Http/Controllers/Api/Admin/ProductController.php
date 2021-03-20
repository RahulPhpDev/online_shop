<?php

namespace App\Http\Controllers\Api\Admin;

use App\Enums\PaginationEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\ProductImageRequest;
use App\Http\Requests\Api\Admin\ProductRequest;
use App\Http\Requests\Api\Admin\ProductUpdateRequest;
use App\Http\Resources\Api\Admin\ProductResource;
use App\Http\Resources\Api\Admin\ProductResourceCollection;
use App\Models\Image;
use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::with('inventory', 'imageable')->paginate(PaginationEnum::CommonPagination);
        return new ProductResourceCollection($product);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // ProductRequest
    public function store(ProductRequest $request)
    {
        DB::beginTransaction();
        try {
        $product = Product::create($request->all());
        $product->inventory()->save(
                    new Inventory( [
                            'quantity' => $request->input('quantity')
                    ]
                )
          );
        if ($request->hasFile('image'))
          $this->uploadImage($request->file('image')  , $product) ;
         DB::commit();
         return new ProductResource($product->loadMissing('unit','inventory','imageable'));
        } catch(\Exception $e)
        {
             DB::rollback();
            dd($e);
        }
     
    }

   

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $product->loadMissing('inventory', 'imageable');
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->all());
        return  (new ProductResource($product->loadMissing('imageable')))-> response()->setStatusCode(200);
    }


 protected function uploadImage($files, $product) 
    {
        foreach($files as $productImage)
        {
            $extension = $productImage->extension();
            $fullFileName = Str::limit($productImage->getClientOriginalName(), 5, '').'_'.$product->id.".".$extension;

            $productImage
                ->storeAs("/public/product/$product->id/",$fullFileName);
            $url = Storage::url("product/$product->id/".$fullFileName);
           $product->imageable()->create(['url' => $url]);   
        }
    }


     /**
     * Add the image for product.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addImage(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $this->uploadImage($request->file('image') , $product) ;    
        return  (new ProductResource($product->loadMissing('imageable')))-> response()->setStatusCode(200);;
    }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function updateImage(ProductImageRequest $request, $id)
    // {
    //     $product = Product::findOrFail($id);
    //     $this->uploadImage($request->file('image') , $product, $imageableId) ;   
    //     return  (new ProductResource($product))-> response()->setStatusCode(200);;
    // }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteImage($id, $imageId)
    {
        $product = Product::findOrFail($id);
       
       $product->imageable()->where('id', $imageId)->delete();
        $product->loadMissing('imageable');
        return  (new ProductResource($product) )-> response()->setStatusCode(200);;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
       $product->delete();
       return response('delete');
    }
}
