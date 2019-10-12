<?php

declare(strict_types=1);

namespace App\Request;

use Hyperf\Contract\ValidatorInterface;

class UserUpdateRequest extends AbstractFormRequest
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
            'id' => 'required|digits:17',
            'nickname' => 'max:30|min:2',
            'gender' => 'between:0,2',
            'email' => 'email',
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
            'id.required' => '用户ID必填',
            'id.digits' => '非法用户ID',
            'username.min' => '密码不能少于4个字符',
            'username.max' => '用户名最多不能超过30个字符',
            'nickname.min' => '密码不能少于2个字符',
            'nickname.max' => '用户名最多不能超过30个字符',
            'gender.between' => '用户性别必须是0-2',
            'email.email' => 'email格式必须正确',
            'birthday.date' => '生日的格式必须为',
            'mobile.regex' => '必须为一个有效的手机号码',
        ];
    }
}
