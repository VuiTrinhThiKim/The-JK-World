<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'productName' => 'bail|required|min:3',
            'productDescription' => 'required|min:10',
            'productContent' => 'required|min: 10',
            'productPrice' => 'required|numeric|min:1000',
            'productWeight' => 'required|min:0',
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
            'productName.required' => 'Tên danh mục không được bỏ trống',
            'productName.min' => 'Tên danh mục phải hơn 3 kí tự',
            'productDescription.required' => 'Mô tả không được bỏ trống',
            'productDescription.min' => 'Mô tả phải ít nhất 10 kí tự',
            'productContent.required' => 'Chi tiết sản phẩm không được bỏ trống',
            'productContent.min' => 'Chi tiết sản phẩm phải ít nhất 10 kí tự',
            'productPrice.required' => 'Giá sản phẩm không được bỏ trống',
            'productPrice.numeric' => 'Giá sản phẩm phải là số',
            'productPrice.min' => 'Giá sản phẩm phải ít nhất 1000₫',
            'productWeight.required' => 'Cân nặng không được bỏ trống',
            'productWeight.min' => 'Cân nặng phải từ 0kg',
        ];
    }
}
