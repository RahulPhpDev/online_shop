<?php

namespace App\Http\Controllers\Api\Admin;

use App\Enums\PaginationEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\BannerRequest;
use App\Http\Resources\Api\Admin\BannerCollection;
use App\Http\Resources\Api\Admin\BannerResource;
use App\Models\Banner;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index():BannerCollection
    {
     return new BannerCollection(Banner::with('imageable')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return BannerResource
     */
    public function store(BannerRequest $request) : BannerResource
    {
          DB::beginTransaction();
          try {
                 $banner = Banner::create($request->all());
                   if ( $request->hasFile('photo'))
                   {
                        foreach( $request->file('photo')  as $photo){
                           $extension = $photo->extension();
                           $id = $banner->id;
                            $fullFileName = $photo->getClientOriginalName().'_'.$id.".".$extension;
                            $photo->storeAs("/public/banner/$id/",$fullFileName);
                            $url = Storage::url("banner/$id/".$fullFileName);
                           $banner->imageable()->create(['url' => $url]);  
                        }
               }
                 DB::commit();
               return new BannerResource($banner->loadMissing('imageable'));
          }    catch(\Exception $e)
        {
             DB::rollback();
             return false;
        }
      
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Banner $banner)
    {
        return new BannerResource($banner->loadMissing('imageable'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BannerRequest $request, Banner $banner)
    {
       $banner->update(
            [
                'title' => $request->title,
                'description' => $request->description,
            ]
        );
       return new BannerResource($banner);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banner $banner)
    {
        $banner->delete();
        return response('deleted');
    }
}
