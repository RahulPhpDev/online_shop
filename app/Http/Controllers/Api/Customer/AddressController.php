<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Customer\AddressRequest;
use App\Http\Resources\Api\Customer\AddressResource;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
	public function index()
	{
		return AddressResource::collection(Address::all());
	}


    public function store(AddressRequest $request)
    {
    	$address = Address::create($request->all());
    	$address->user()->sync(Auth::id());
    	return new AddressResource($address->loadMissing('user'));
    }

    public function destroy($id)
    {
    	$address = Address::findOrFail($id);
    	$address = $address->delete($id);
    	return 'delete';
    }

    public function show($id)
    {
    	$address =  Address::findOrFail($id);
    	return new AddressResource($address);
    }

    public function update(AddressRequest $request,$id)
    {
		$address = Address::findOrFail($id);
		$address ->update($request->all());
		return new AddressResource($address);
    }
}
