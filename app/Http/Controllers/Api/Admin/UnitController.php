<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Enums\PaginationEnum;
use App\Http\Resources\Api\Admin\{UnitResource,UnitCollection};
use App\Http\Requests\Api\Admin\UnitRequest;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $units = Unit::paginate(PaginationEnum::CommonPagination);
        return new UnitCollection($units);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UnitRequest $request)
    {
        $unit = Unit::create($request->all());
        $unitResource =  new UnitResource($unit);
        return $unitResource;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $unit = Unit::findOrFail($id);
        $unitResource =  new UnitResource($unit);
        return $unitResource;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UnitRequest $request, $id)
    {
        $unit = Unit::findOrFail($id);
        $unit->update($request->all());
        $unitResource =  new UnitResource($unit);
        return $unitResource;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $unit = Unit::withCount('product')->findOrFail($id);
       if ($unit->product_count) {
        return response("$unit->product_count product related to $unit->name unit" );
       }
        $unit->delete();
        return response('Unit Deleted');
    }
}
