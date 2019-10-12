<?php

declare(strict_types=1);

namespace App\Exception;

use App\Constants\StatusCode;
use Hyperf\Server\Exception\ServerException;
use Throwable;

class BusinessException extends ServerException
{
    protected $statusCode = '';

    protected $httpCode = 0;

    protected $data;

    public function __construct($statusCode, string $message = null, $data = null, Throwable $previous = null)
    {
        $this->statusCode = $statusCode;
        $this->httpCode = StatusCode::getHttpCode($this->statusCode);
        if (is_null($message)) {
            $message = StatusCode::getMessage($this->statusCode);
        }
        $this->data = $data;

        parent::__construct($message, $this->httpCode, $previous);
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function getHttpCode()
    {
        return $this->httpCode;
    }

    public function getData()
    {
        return $this->data;
    }
}
