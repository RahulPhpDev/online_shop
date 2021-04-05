<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
           
            'email' => 'required_with:password',
            'password' => 'required_with:email',

             'phone' => 'required_with_all:otp',
            'otp' => 'required_with_all:phone',
            'country_code' => 'required_with_all:phone,',
        ];
    }
}
