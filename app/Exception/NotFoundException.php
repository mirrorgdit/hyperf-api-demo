<?php

declare(strict_types=1);

namespace App\Exception;

use App\Constants\StatusCode;
use Throwable;

class NotFoundException extends BusinessException
{
    public function __construct(string $message = null, $data = null, Throwable $previous = null)
    {
        parent::__construct(StatusCode::NotFound, $message, $data, $previous);
    }
}
