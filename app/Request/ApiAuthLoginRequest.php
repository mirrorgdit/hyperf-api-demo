<?php

declare(strict_types=1);

namespace App\Request;

use Hyperf\Contract\ValidatorInterface;

class ApiAuthLoginRequest extends AbstractFormRequest
{
    /**
     * @var ValidatorInterface
     */
    protected $validator;

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
            'app_id' => 'required',
            'app_secret' => 'required',
        ];
    }

    /**
     * Get custom messages for validator errors.
     * @return array
     */
    public function messages(): array
    {
        return [
            'app_id.required' => 'app_id不能为空',
            'app_secret.required' => 'app_secret不能为空',
        ];
    }
}
