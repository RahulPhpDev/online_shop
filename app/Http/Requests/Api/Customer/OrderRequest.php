<?php

namespace App\Http\Requests\Api\Customer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
class OrderRequest extends FormRequest
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
            'user_address_id' => ['required'],
            'product_id.*' => ['required'],
            'quantity.*' => ['required'],
        ];
    }

    protected function prepareForValidation() {
        $this->merge([
                'reference' =>  (string) Str::uuid(),
                'user_id' => Auth::id(),
                'status' => 0
            ]);
    }
}
