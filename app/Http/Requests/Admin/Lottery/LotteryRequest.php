<?php

namespace App\Http\Requests\Admin\Lottery;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class LotteryRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() == true && auth()->user()['role'] == User::ADMIN;
    }

    public function rules()
    {
        return [
            'g-recaptcha-response' => ['required', 'captcha']
        ];
    }

    public function messages()
    {
        return [
            'g-recaptcha-response.required' => 'فیلد ریکپچا الزامی است.',
            'g-recaptcha-response.captcha' => 'لطفا فیلد ریکپچا را مجداد پر کنید.'
        ];
    }
}
