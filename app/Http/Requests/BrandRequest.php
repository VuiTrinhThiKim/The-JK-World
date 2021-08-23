<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
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
            'brandName' => 'bail|required|min:3',
            'brandDescription' => 'required|min:15',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'brandName.required' => 'Tên brand không được bỏ trống',
            'brandName.min' => 'Tên brand phải hơn 3 kí tự',
            'brandDescription.required' => 'Mô tả không được bỏ trống',
            'brandDescription.min' => 'Mô tả phải ít nhất 15 kí tự',
        ];
    }
}
