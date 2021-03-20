<?php

namespace App\Http\Requests\Api\Admin;

use App\Enums\RoleEnums;
use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
       return [
            'name' => ['bail','required', 'min:2'],
            'description' => ['bail','required', 'min:2'],
            'unit_id' => ['bail','required', 'exists:App\Models\Unit,id'],
            'is_popular' => ['nullable'],
            'price' => ['required', 'numeric'],
            'quantity' => ['required'],
            'feature' => ['nullable']
        ];
    }
}
