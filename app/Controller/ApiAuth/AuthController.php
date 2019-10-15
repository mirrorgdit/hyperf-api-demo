<?php

declare(strict_types=1);

namespace App\Controller\ApiAuth;

use App\Controller\AbstractController;
use App\Constants\StatusCode;
use App\Kernel\ResponseCreater;
use App\Lib\JsonWebToken;
use App\Service\ApiAuthClientService;
use App\Service\QueueService;
use App\Request\ApiAuthLoginRequest;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\ResponseInterface;

/**
 * api 授权获取token
 * Class AuthController
 * @package App\Controller
 */
class AuthController extends AbstractController
{
    /**
     * 通过 `@Inject` 注解注入由 `@var` 注解声明的属性类型对象
     *
     * @Inject
     * @var ResponseCreater
     */
    private $responseCreater;
    /**
     * 通过 `@Inject` 注解注入由 `@var` 注解声明的属性类型对象
     *
     * @Inject
     * @var QueueService
     */
    private $queueService;
    /**
     * 通过 `@Inject` 注解注入由 `@var` 注解声明的属性类型对象
     *
     * @Inject
     * @var ApiAuthClientService
     */
    private $apiAuthClientService;

    /**
     * @param ApiAuthLoginRequest $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function login(ApiAuthLoginRequest $request, ResponseInterface $response)
    {
        //验证参数
        $validated = $request->validated();
        //登录验证
        $user = $this->apiAuthClientService->login($validated['app_id'], $validated['app_secret']);
        if ($user === false) {
            return $this->responseCreater->error($request,$response, StatusCode::AccountPasswordInvalid);
        }
        $data = [
            'access_token' => JsonWebToken::getToken(['app_id' => $validated['app_id'], 'app_secret' => $validated['app_secret']]),
            'expire_in' => config('jwt.exp'),
        ];
        return $this->responseCreater->success($request,$response, $data);
    }


}
