<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
            'username' => 'bail|required|min:3',
            'password' => 'required|min:8|confirmed',
            'adEmail' => 'email|required',
            'firstName' => 'required',
            'lastName' => 'required',
            'adAvatar' => 'mimes:jpg,bmp,png',
            'adPhone' => 'required|size:10',
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
            'username.required' => 'Tên brand không được bỏ trống',
            'username.min' => 'Tên brand phải hơn 3 kí tự',
            'password.required' => 'Mật khẩu không được bỏ trống',
            'password.min' => 'Mật khẩu phải ít nhất 8 kí tự',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp',
            'adEmail.email' => 'E-mail không hợp lệ',
            'adEmail.required' => 'E-mail không được bỏ trống',
            'firstName.required' => 'Tên không được bỏ trống',
            'lastName.required' => 'Họ không được bỏ trống',
            'adAvatar.mimes' => 'Định dạng file phải là .jpg, .jpeg, .bmp hoặc .png',
            'adPhone.required' => 'Phải nhập số điện thoại',
            'adPhone.size' => 'Số điện thoại phải là 10 số',
        ];
    }
}
