<?php

declare(strict_types=1);

namespace App\Kernel;

use App\Constants\StatusCode;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\HttpServer\Response;
use Psr\Http\Message\ResponseInterface as PsrResponseInterface;

class ResponseCreater
{
    /**
     * @param ResponseInterface|PsrResponseInterface $response
     * @param string|null $statusCode
     * @param string|null $message
     * @param $data
     * @return PsrResponseInterface
     */
    public static function create($response, ?string $statusCode, ?string $message, $data): PsrResponseInterface
    {
        $result = new ResponseJson([
            'code' => StatusCode::getHttpCode($statusCode),
            'message' => $message,
            'data' => $data
        ]);

        if (!$response instanceof ResponseInterface) {
            $response = new Response($response);
        }
        return $response->withStatus(StatusCode::getHttpCode($statusCode))->json($result);
    }

    /**
     * @param ResponseInterface|PsrResponseInterface $response
     * @param $data
     * @param string|null $message
     * @return PsrResponseInterface
     */
    public static function success($response, $data, ?string $message = null): PsrResponseInterface
    {
        $statusCode = StatusCode::Success;
        $message = $message ?? StatusCode::getMessage(StatusCode::Success);

        return static::create($response, $statusCode, $message, $data);
    }

    /**
     * @param ResponseInterface|PsrResponseInterface $response
     * @param string $statusCode
     * @param string|null $message
     * @param null $data
     * @return PsrResponseInterface
     */
    public static function error($response, string $statusCode, ?string $message = null, $data = null): PsrResponseInterface
    {
        $message = $message ?? StatusCode::getMessage($statusCode);

        return static::create($response, $statusCode, $message, $data);
    }
}
