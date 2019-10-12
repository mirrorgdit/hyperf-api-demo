<?php

declare(strict_types=1);

namespace App\Request;

use Hyperf\Contract\ValidatorInterface;

class UserLoginRequest extends AbstractFormRequest
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
            'username' => 'required|max:30|min:4',
            'password' => 'required|max:30|min:6',
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
        ];
    }
}
