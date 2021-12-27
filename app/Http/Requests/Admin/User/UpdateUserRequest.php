<?php

namespace App\Http\Requests\Admin\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() == true && auth()->user()['role'] == User::ADMIN;
    }

    public function rules()
    {
        $id = request()->route('user')->id;

        return [
            'f_name' => ['required', 'string', 'max:255', 'unique:users,f_name,' . $id],
            'l_name' => ['required', 'string', 'max:255', 'unique:users,l_name,' . $id],
            'email' => ['required', 'string', 'email', 'unique:users,email,' . $id],
            'password' => ['nullable', 'string', 'min:8']
        ];
    }

    public function attributes()
    {
        return [
            'f_name' => 'نام کاربر',
            'l_name' => 'نام خانوادگی کاربر',
            'email' => 'ایمیل کاربر',
            'password' => 'رمز عبور کاربر'
        ];
    }
}
