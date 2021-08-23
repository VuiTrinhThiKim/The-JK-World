<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'categoryName' => 'bail|required|min:5',
            'categoryDescription' => 'required|min:15',
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
            'categoryName.required' => 'Tên danh mục không được bỏ trống',
            'categoryName.min' => 'Tên danh mục phải hơn 3 kí tự',
            'categoryDescription.required' => 'Mô tả không được bỏ trống',
            'categoryDescription.min' => 'Mô tả phải ít nhất 15 kí tự',
        ];
    }
}
