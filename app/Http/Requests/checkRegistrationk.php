<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class checkRegistrationk extends FormRequest
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
            'customer_email' => 'required|regex:/^[A-Za-z0-9_.]{6,32}@([a-zA-Z0-9]{2,12})(.[a-zA-Z]{2,12})+$/',
            'customer_name' => 'required||min:6|max:50',
            'customer_phone' => 'required|regex:/(0)[0-9]{9}/',
            'customer_password' => 'required||min:8|max:32|regex:/^([A-Z]){1}([\w_\.!@#$%^&*()]+)$/'
        ];
    }
    public function messages()
    {
        return [



            // đăng ký và đăng nhập
            'customer_email.regex' => __('Email chưa đúng định dạng'),
            'customer_password.regex' => __('mật khẩu phải có ký tự đầu in hoa và có cả chữ và số'),

            'customer_phone.regex' => __('số điện thoại chưa đúng định dạng'),

            'customer_password.min' => __('mật khẩu phải hơn 8 ký tự'),
            'customer_password.max' => __('mật khẩu phải không được vượt quá 32 ký tự'),

            'customer_name.min' => __('mật khẩu phải hơn 6 ký tự'),
            'customer_name.max' => __('mật khẩu phải không được vượt quá 50 ký tự'),


        ];
    }
}
