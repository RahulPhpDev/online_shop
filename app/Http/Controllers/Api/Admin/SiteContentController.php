<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\SiteContentRequest;
use App\Http\Resources\Api\Admin\SiteContentResource;
use App\Models\SiteContent;
use Illuminate\Http\Request;

class SiteContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $records = SiteContent::all();
       return SiteContentResource::collection($records);
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SiteContentRequest $request)
    {
       $siteContent = SiteContent::create(
            $request->all()
       );
        return new SiteContentResource($siteContent);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(SiteContent $siteContent)
    {
      return new SiteContentResource($siteContent);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SiteContentRequest $request, SiteContent $siteContent)
    {
        $siteContent->update($request->only('title', 'description'));
        return new SiteContentResource($siteContent);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(SiteContent $siteContent)
    {
        $siteContent->delete();
        return response('deleted');
    }
}
