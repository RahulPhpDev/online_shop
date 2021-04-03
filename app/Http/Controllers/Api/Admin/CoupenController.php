<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\
{CoupenRequest, AddProductInCoupenRequest};
use App\Http\Resources\Api\Admin\CoupenCollection;
use App\Http\Resources\Api\Admin\CoupenResource;
use App\Models\Coupen;
use Illuminate\Http\Request;

class CoupenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $coupen = Coupen::all( );
        return new CoupenCollection($coupen);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CoupenRequest $request)
    {
        $coupen = Coupen::create( $request->all() );
       return new CoupenResource($coupen);

    }

    public function addProduct(AddProductInCoupenRequest $request)
    {
        $coupen = Coupen::findOrfail($request->coupen_id);
        $coupen->product()->sync([$request->product_id], false);
        $data = $coupen->loadMissing('product');
        return [
            'data' => $data,
            'result' => 1,
            'msg' => 'success'
        ];
    }



    public function removeProduct(AddProductInCoupenRequest $request)
    {
        try {
           $coupen = Coupen::findOrfail($request->coupen_id); 
           $coupen->product()->detach([$request->product_id]);
             $data = $coupen->loadMissing('product');
            return [
                'data' => $data,
                'result' => 1,
                'msg' => 'removed'
            ];
        } catch (\Exception $e) {
                   return [
                        'data' => $data->getMessage(),
                        'result' => 1,
                        'msg' => 'fail'
                    ];
        }
     
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CoupenRequest $request, $id)
    {
       $coupen = Coupen::findOrFail($id);
       $coupen->update( $request->all() );
       return new CoupenResource($coupen);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $coupen = Coupen::findOrfail($id);
        $coupen->product()->detach();
        $coupen->delete();
        return [
                'data' => 'removed',
                'result' => 1,
                'msg' => 'removed'
            ];
    }
}
