<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckShipping extends FormRequest
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
            'shipping_email' => 'required|regex:/^[A-Za-z0-9_.]{6,32}@([a-zA-Z0-9]{2,12})(.[a-zA-Z]{2,12})+$/',
            'shipping_name' => 'required||min:6|max:50',
            'shipping_phone' => 'required|regex:/(0)[0-9]{9}/'
        ];
    }
    public function messages()
    {
        return [






            // thông tin đặt hàng
            'shipping_email.regex' => __('Email chưa đúng định dạng'),

            'shipping_phone.regex' => __('số điện thoại chưa đúng định dạng'),

            'shipping_name.min' => __('mật khẩu phải hơn 6 ký tự'),
            'shipping_name.max' => __('mật khẩu phải không được vượt quá 50 ký tự'),

        ];
    }
}
