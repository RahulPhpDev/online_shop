<?php

namespace App\Http\Requests\Api\Admin;
use App\Enums\RoleEnums;
use Illuminate\Foundation\Http\FormRequest;

class AddProductInCoupenRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return  $this->user()->role_id === RoleEnums::ADMIN;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_id' => ['required','exists:products,id'],
            'coupen_id' => ['required','exists:coupens,id']
        ];
    }
}
