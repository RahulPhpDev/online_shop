<?php

namespace App\Http\Controllers\Api\Auth;

use App\Enums\ResponseMessages;
use App\Enums\RoleEnums;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RegisterRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{

    public function register(RegisterRequest $request)
    {

        $validRecord = $request->all();
        $validRecord['role_id'] = RoleEnums::CUSTOMER;
        $user = User::create($validRecord);
        $user->token = $user->createToken('authToken')->accessToken;

        $response = [
            'result' => 1,
            'msg' => ResponseMessages::REGISTERED,    
            'data' => $user
          ];
        return response($response, 200);
    }
}
