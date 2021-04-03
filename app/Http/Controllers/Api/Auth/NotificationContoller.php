<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\
{NotificationCollection,NotificationResource};
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\CommonResponse;
class NotificationContoller extends Controller
{
use CommonResponse;


    public function index()
    {
    	$notification = \Auth::user()->notifications;
		return  new NotificationCollection($notification);		
    }


    public function update($notificationId)
    {
    	$notification = \Auth::user()->notifications()->find($notificationId);
    	$notification->update(['read_at' => now()]);
    	return new NotificationResource($notification);
    }


    public function destroy($notificationId)
    {
    	$notification = \Auth::user()->notifications()->where('id', $notificationId)->first();
    	$notification->delete();
		return $this->successResponse;
    }

    public function unread()
    {
    	$notification = \Auth::user()->unreadNotifications;
    	return new NotificationCollection($notification);
    }
}
