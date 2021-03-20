<?php

namespace App\Http\Requests\Api\Customer;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return request()->user()->exists();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'house_no'  => ['required'],
            'street' => ['required'],
            'state' => ['required'],
            'district' => ['required'],
            'pin_code' => ['required'],
            'landmark' => ['required'],
            'type' =>   ['required']
        ];
    }
}
