<?php

namespace App\Http\Controllers\Api\Auth;

use App\Enums\RoleEnums;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\OtpRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

    public function otp(OtpRequest $request)
    {
      
        $password =   rand(1000,9999);
        $user = User::firstOrCreate(['phone' => $request->phone], ['country_code' => $request->country_code, 'role_id' => RoleEnums::CUSTOMER]);
        $user->password = $password;
        $user->save();

        return response()->json([
            'result' => 1,
            'msg' => 'Otp send',
            'otp' => $password
        ]);
    }


    public function login (LoginRequest $request) {
        $matchForPassword = $request->password ?? $request->otp; 
        if ( $request->email){
          $user = User::where('email', $request->email)->first();
        } else {
        $user = User::where('phone', $request->phone)->where('country_code', $request->country_code)->first();
        }


        if ($user) {
            if (Hash::check($matchForPassword, $user->password)) {
                $token = $user->createToken('authToken')->accessToken;
                $user->token = $token;
                $response = [
                                'result' => 1,
                              'msg' => 'Otp Verified',
                              'data' => $user
                          ];
                return response($response, 200);
            } else {
                $response = ["msg" => "Otp mismatch", 'result' => 0 , 'data' => null];
                return response($response, 422);
            }
        } else {
            $response = ["msg" =>'Otp does not exist', 'result' => 0 , 'data' => null];
            return response($response, 422);
        }
    }

    public function logout (Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        $response = [
               'result' => 1,
              'msg' => 'You have been successfully logged out!',
              'data' => []
          ];
        return response($response, 200);
    }

}
