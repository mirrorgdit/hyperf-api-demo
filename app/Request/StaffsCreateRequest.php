<?php

declare(strict_types=1);

namespace App\Request;

use Hyperf\Contract\ValidatorInterface;

class StaffsCreateRequest extends AbstractFormRequest
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
            'id' => 'required'
        ];
    }
}
