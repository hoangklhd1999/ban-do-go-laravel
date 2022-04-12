<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckLogin extends FormRequest
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
            'admin_email' => 'required|min:5|max:255|regex:/^[A-Za-z0-9_.]{6,32}@([a-zA-Z0-9]{2,12})(.[a-zA-Z]{2,12})+$/',
            'admin_password' => 'required||min:8|max:32|regex:/^([A-Z]){1}([\w_\.!@#$%^&*()]+)$/'

        ];
    }
    public function messages()
    {
        return [
            'admin_email.required' => __('Bạn chưa nhập admin_email.'),
            'admin_password.regex' => __('Mật khẩu chưa đúng định dạng.'),
            'admin_email.min' => __('admin_email phải hơn 5 ký tự.'),
            'admin_email.max' => __('admin_email phải không được vượt quá 255 ký tự.'),
            'admin_password.min' => __('Mật khẩu phải hơn 8 ký tự.'),
            'admin_password.max' => __('Mật khẩu phải không được vượt quá 32ký tự.')
        ];
    }
}
