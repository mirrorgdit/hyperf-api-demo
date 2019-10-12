<?php
declare(strict_types=1);

namespace App\Service;

use App\Model\ApiAuthClient;

class ApiAuthClientService
{
    /**
     * 登录验证
     * @param string $username
     * @param string $password
     * @return bool
     */
    public function login(string $username, string $password)
    {
        //判断帐号是否存在
        $user = ApiAuthClient::where(['app_id' => $username, 'status' => 1])->select('app_id', 'app_secret')->first();
        if ($user === null) {
            return false;
        }
        //判断密码
        if (!password_verify($password, $user['app_secret'])) {
            return false;
        }
        return true;
    }

}