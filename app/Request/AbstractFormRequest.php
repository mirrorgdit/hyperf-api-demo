<?php

declare(strict_types=1);

namespace App\Request;

use App\Exception\ParamaterException;
use Hyperf\Contract\ValidatorInterface;
use Hyperf\Validation\Request\FormRequest;

abstract class AbstractFormRequest extends FormRequest
{
    /**
     * @var ValidatorInterface
     */
    protected $validator;

    protected function withValidator(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function getData()
    {
        return $this->validator->getData();
    }

    protected function failedValidation(ValidatorInterface $validator)
    {
        throw new ParamaterException(null, $validator->errors());
    }
}
