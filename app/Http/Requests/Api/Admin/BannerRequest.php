<?php

namespace App\Http\Requests\Api\Admin;

use App\Enums\RoleEnums;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class BannerRequest extends FormRequest
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
            'title' => 'required',
            // 'slug' => 'required',
            'description' => 'required',
//            'src'
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'slug' => Str::slug(Str::limit(Str::lower($this->title), 20, '') ),
            'src' => $this->src ??  ''
        ]);
    }
}
