<?php

namespace App\Http\Controllers\Api\Auth;

use App\Enums\RoleEnums;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;

class RegisterController extends Controller
{

    public function register(Request $request)
    {

        $record = $this->validate(request(), [
           'email' => 'required|email|unique:users',
           'phone' => 'required',
           'password' => 'required',
           'name' => 'required',
           // 'role_id' => 'required'
        ]);
        $record['role_id'] = RoleEnums::CUSTOMER;
        // dd( $record);
        $user = User::create($record);
        $accessToken = $user->createToken('authToken')->accessToken;

//        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        $response = ['token' => $accessToken, 'user' => $user];
        return response($response, 200);
    }
}
