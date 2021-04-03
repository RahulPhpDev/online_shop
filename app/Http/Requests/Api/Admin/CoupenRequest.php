<?php

namespace App\Http\Requests\Api\Admin;

use App\Enums\RoleEnums;
use Illuminate\Foundation\Http\FormRequest;

class CoupenRequest extends FormRequest
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
            'name' => ['required'],
            'code' => ['required', 'min:3', 'max:20'],
            'description' => ['required'],
            'type' => ['required'],
            'expire_at' => ['required'],
            'discount' => ['required']
        ];
    }
}
