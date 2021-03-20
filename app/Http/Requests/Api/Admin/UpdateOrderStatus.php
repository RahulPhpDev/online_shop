<?php

namespace App\Http\Requests\Api\Admin;
use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\{
    RoleEnums,
    OrderStatus
};
class UpdateOrderStatus extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->role_id === RoleEnums::ADMIN;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // required_if:anotherfield,value,...

           //          Rule::requiredIf(
           //              function () {
           //                 return OrderStatus::DECLINE;
           //              }),
           // ] ,
        return [
            'status' => 'required',
           'expect_delivery' => ['date','required_if:status,1'],
           'received' => ['date','required_if:status,3'] ,
           'reject' => ['string','required_if:status,4'] 
        ];
    }
}
