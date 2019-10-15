<?php

declare(strict_types=1);

/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

use Hyperf\HttpServer\Router\Router;
use App\Middleware\Auth\AuthMiddleware;

Router::addRoute(['GET', 'POST', 'HEAD'], '/', 'App\Controller\IndexController@index');

//api 授权登录获取token
Router::post('/api-auth/login', 'App\Controller\ApiAuth\AuthController@login');

//需AUTH验证的接口
Router::addGroup('/api/', function () {
    //用户登录
    Router::post('user-login', 'App\Controller\User\UserController@login');
    //用户注册
    Router::post('user-register', 'App\Controller\User\UserController@register');
    //用户信息
    Router::post('user-info', 'App\Controller\User\UserController@info');
    //用户信息更新
    Router::post('user-update', 'App\Controller\User\UserController@updateInfo');
    //用户列表
    Router::post('user-list', 'App\Controller\User\UserController@list');
}, ['middleware' => [AuthMiddleware::class]]);
