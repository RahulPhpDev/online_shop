<?php

namespace App\Http\Controllers\Api\Auth;

use App\Enums\RoleEnums;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

    public function otp(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'country_code' => 'required',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
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

    public function login (Request $request) {
        $validator = Validator::make($request->all(), [

            // 'phone' => 'required',
            // 'otp' => 'required',
            // 'country_code' => 'required',

            'email' => 'required_with:password',
            'password' => 'required_with:email',

             'phone' => 'required_with_all:otp',
            'otp' => 'required_with_all:phone',
            'country_code' => 'required_with_all:phone,',

        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

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
                $response = ["message" => "Otp mismatch"];
                return response($response, 422);
            }
        } else {
            $response = ["message" =>'Otp does not exist'];
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
