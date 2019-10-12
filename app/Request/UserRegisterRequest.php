<?php

declare(strict_types=1);

namespace App\Request;

use Hyperf\Contract\ValidatorInterface;

class UserRegisterRequest extends AbstractFormRequest
{
    /**
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'username' => 'required|max:30|min:4|unique:users',
            'password' => 'required|max:30|min:6|confirmed',
            'password_confirmation' => 'required|same:password',
            'nickname' => 'required|max:30|min:2',
            'gender' => 'required|between:0,2',
            'email' => 'required|email',
            'birthday'=>'date',
            'mobile' => 'regex:/^1[345789][0-9]{9}$/'
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'username.required' => '用户名必须',
            'username.min' => '密码不能少于4个字符',
            'username.max' => '用户名最多不能超过30个字符',
            'username.unique' => '用户名已存在',
            'password.required' => '密码必须',
            'password.min' => '密码不能少于6个字符',
            'password.max' => '密码不能超过30个字符',
            'password.confirmed' => '两次密码不一致',
            'nickname.required' => '昵称必须',
            'nickname.min' => '密码不能少于2个字符',
            'nickname.max' => '用户名最多不能超过30个字符',
            'gender.between' => '用户性别必须是0-2',
            'email.required' => 'email必须',
            'email.email' => 'email格式必须正确',
            'birthday.date' => '生日的格式必须为',
            'mobile.regex' => '必须为一个有效的手机号码',
        ];
    }
}
