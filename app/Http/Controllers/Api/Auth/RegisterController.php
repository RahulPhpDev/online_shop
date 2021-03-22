<?php

namespace App\Http\Controllers\Api\Auth;

use App\Enums\ResponseMessages;
use App\Enums\RoleEnums;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{

    public function register(Request $request)
    {

        $record = Validator::make($request->all(), [
            'phone' => 'required|unique:users',
            'country_code' => 'required',
            'gender' => 'nullable'
        ]);

        //  $this->validate(request(), [
        //     'phone' => 'required|unique:users',
        //     'country_code' => 'required',
        //     'gender' => 'nullable'
        // ]);
         if ($record->fails())
        {
            return response(['result' => 1,
            'msg' => ResponseMessages::NOTVALID,
            'data'=>$record->errors()->all()
          ], 422);
        }
        $validRecord = $record->valid();
        $validRecord['role_id'] = RoleEnums::CUSTOMER;
        // dd( $validRecord);
        $user = User::create($validRecord);
        $user->token = $user->createToken('authToken')->accessToken;

//        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        $response = [
            'result' => 1,
            'msg' => ResponseMessages::REGISTERED,    
            'data' => $user
          ];
        return response($response, 200);
    }
}
