<?php
declare(strict_types=1);

namespace App\Middleware\Auth;

use App\Constants\StatusCode;
use App\Kernel\ResponseCreater;
use App\Lib\JsonWebToken;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface as HttpResponse;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AuthMiddleware implements MiddlewareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;
    /**
     * @var RequestInterface
     */
    protected $request;
    /**
     * @var HttpResponse
     */
    protected $response;

    protected $prefix = 'Bearer';

    public function __construct(ContainerInterface $container, HttpResponse $response, RequestInterface $request)
    {
        $this->container = $container;
        $this->response = $response;
        $this->request = $request;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        //判断白名单
        $ip = $request->getHeader('x-real-ip')[0];   // 获取IP
        if (!in_array($ip, config('whitelist.ip'))) {
            return ResponseCreater::error($this->response, StatusCode::Forbidden);
        }
        // 根据具体业务判断逻辑走向，这里假设用户携带的token有效
        $token = $request->getHeader('Authorization')[0] ?? '';
        if (strlen($token) > 0) {
            $token = ucfirst($token);
            $arr = explode($this->prefix . ' ', $token);
            $token = $arr[1] ?? '';
            $jwt = JsonWebToken::checkToken($token);
            if ($jwt['code'] == 200) {
                return $handler->handle($request);
            }
        }
        return ResponseCreater::error($this->response, StatusCode::Console_Connect_TokenInvalid, $jwt['msg'], ['errmsg' => $jwt['error']]);
    }
}