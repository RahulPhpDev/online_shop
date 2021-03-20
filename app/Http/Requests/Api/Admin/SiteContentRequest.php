<?php

namespace App\Http\Requests\Api\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use App\Enums\RoleEnums;
class SiteContentRequest extends FormRequest
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
            'title' => ['required', 'min:2', 'max:100'],
            'description' => ['required', 'min:2', 'max:200'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
             'slug' => Str::slug(Str::limit($this->title, 20, '') ),
             'visible' => 0
        ]);
    }
}
