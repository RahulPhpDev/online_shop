<?php

namespace App\Http\Controllers\Api\Admin;

use App\Enums\{
	PaginationEnum,
	OrderStatus
};
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\UpdateOrderStatus;
use Illuminate\Http\Request;
use App\Models\{
	Order
};

class AdminOrderController extends Controller
{
    public function index()
    {
    	return Order::with('product')->latest()->paginate(PaginationEnum::CommonPagination);
    }

    public function show($id)
    {
    	return Order::with('product')->findOrFail($id);	
    }

    public function updateStatus(UpdateOrderStatus $request, $id)
    {
    	$order = Order::findOrFail($id);
    	$order->update($request->all());
    	return $order;
    }
}
