<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Customer\FavouriteProductCollection;
use App\Http\Resources\Api\Customer\FavouriteProductResource;
use App\Models\Product;
use App\User;
use Illuminate\Http\Request;

class FavouriteProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user =  User::loginUser();
        return new FavouriteProductResource($user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::loginUser();
       $record = $user->favouriteProduct()->sync([$request->product], false);
     
       return [
             'result' => 1,
              'msg' => 'added',
              'data' => [ 'product_id' => $request->product ]
       ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::loginUser();
       $record = $user->favouriteProduct()->detach([$id]);

       return [
             'result' => 1,
              'msg' => 'removed',
              'data' => [ 'product_id' => $id ]
       ];
    }
}
