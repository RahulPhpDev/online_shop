<?php

namespace App\Http\Requests\Api\Customer;

use App\Enums\RoleEnums;
use Illuminate\Foundation\Http\FormRequest;

class CreateCartRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return request()->user()->role_id === RoleEnums::CUSTOMER;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required']
        ];
    }
}
