<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Controller\AbstractController;
use App\Constants\StatusCode;
use App\Event\UserRegistered;
use App\Kernel\ResponseCreater;
use App\Model\User;
use App\Request\UserLoginRequest;
use App\Request\UserRegisterRequest;
use App\Request\UserUpdateRequest;
use App\Service\UserService;
use App\Service\QueueService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

/**
 * 用户登录
 * Class UserController
 * @package App\Controller\User
 */
class UserController extends AbstractController
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
     * @Inject
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @Inject()
     * @var ValidatorFactoryInterface
     */
    protected $validationFactory;
    /**
     * 通过 `@Inject` 注解注入由 `@var` 注解声明的属性类型对象
     *
     * @Inject
     * @var UserService
     */
    private $userService;

    /**
     * @param UserLoginRequest $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function login(UserLoginRequest $request, ResponseInterface $response)
    {
        //验证参数
        $validated = $request->validated();
        //登录验证
        $user = $this->userService->login($validated['username'], $validated['password']);
        if ($user === false) {
            return $this->responseCreater->error($request, $response, StatusCode::AccountPasswordInvalid);
        }
        return $this->responseCreater->success($request, $response, ['uid' => $user['uuid']], StatusCode::getMessage(StatusCode::Success));
    }

    /**
     * @param UserRegisterRequest $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function register(UserRegisterRequest $request, ResponseInterface $response)
    {
        //验证参数
        $validated = $request->validated();
        $validated['ip'] = $request->getHeader('x-real-ip')[0];
        //注册
        $user = $this->userService->register($validated);

        if ($user['code'] == '-1') {
            return $this->responseCreater->error($request, $response, StatusCode::ServerError);
        }
        // 完成账号注册的逻辑
        // 这里 dispatch(object $event) 会逐个运行监听该事件的监听器 监听器注册成功 触发发注册成功的邮件
        $this->eventDispatcher->dispatch(new UserRegistered($user, $this->queueService));
        return $this->responseCreater->success($request,$response, ['uid' => $user['data']['uuid']], StatusCode::getMessage(StatusCode::Success));
    }

    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function info(RequestInterface $request, ResponseInterface $response)
    {
        //验证参数
        $validator = $this->validationFactory->make($request->all(), ['id' => 'required|digits:17'], ['id.required' => '缺乏必填参数', 'id.digits' => '非法参数']);
        if ($validator->fails()) {
            $errorMessage = $validator->errors()->first();
            return $this->responseCreater->error($request, $response, StatusCode::AccountPasswordInvalid, $errorMessage);
        }
        $user = $this->userService->info($request->all()['id']);
        return $this->responseCreater->success($request, $response, $user, StatusCode::getMessage(StatusCode::Success));
    }

    /**
     * 更新信息
     * @param UserUpdateRequest $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function updateInfo(UserUpdateRequest $request, ResponseInterface $response)
    {
        //验证参数
        $validated = $request->validated();
        $uuid = $validated['id'];

        $user = User::query()->where('uuid', $uuid)->first();
        if ($user === null) {
            return ResponseCreater::error($request, $response, StatusCode::AccountPasswordInvalid, '无效的用户');
        }
        //更新
        $user = $this->userService->doUpdate($validated);
        if ($user['code'] == '-1') {
            return ResponseCreater::error($request, $response, StatusCode::ServerError);
        }
        return ResponseCreater::success($request, $response, [], StatusCode::getMessage(StatusCode::Success));
    }

    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function list(RequestInterface $request, ResponseInterface $response)
    {
        //验证参数
        $validator = $this->validationFactory->make($request->all(), ['page' => 'numeric'], ['page.numeric' => '非法参数']);
        if ($validator->fails()) {
            $errorMessage = $validator->errors()->first();
            return $this->responseCreater->error($request, $response, StatusCode::ParamaterInvalid, $errorMessage);
        }
        $user = $this->userService->list();
        return $this->responseCreater->success($request, $response, $user, StatusCode::getMessage(StatusCode::Success));
    }
}
