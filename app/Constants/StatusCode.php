<?php

declare(strict_types=1);

namespace App\Constants;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;
use Hyperf\Constants\Exception\ConstantsException;

/**
 * @Constants
 */
class StatusCode extends AbstractConstants
{
    /**
     * @HttpCode("200")
     * @Message("请求成功")
     */
    const Success = 'Success';

    /**
     * @HttpCode("422")
     * @Message("无效参数")
     */
    const ParamaterInvalid = 'ParamaterInvalid';

    /**
     * @HttpCode("401")
     * @Message("无效账号或密码错误")
     */
    const AccountPasswordInvalid = 'AccountPasswordInvalid';

    /**
     * @HttpCode("401")
     * @Message("账号已锁定")
     */
    const AccountLocked = 'AccountLocked';

    /**
     * @HttpCode("401")
     * @Message("账号已离线")
     */
    const AccountOffline = 'AccountOffline';

    /**
     * @HttpCode("401")
     * @Message("密钥错误或超时")
     */
    const AccessKeyInvalid = 'AccessKeyInvalid';

    /**
     * @HttpCode("403")
     * @Message("未授权对该资源的操作")
     */
    const Forbidden = 'Forbidden';

    /**
     * @HttpCode("404")
     * @Message("资料不存在")
     */
    const NotFound = 'NotFound';

    /**
     * @HttpCode("409")
     * @Message("发生冲突，该资料已创建")
     */
    const SourceConflict = 'SourceConflict';

    /**
     * @HttpCode("500")
     * @Message("服务器发生异常")
     */
    const ServerError = 'ServerError';

    /**
     * @HttpCode("500")
     * @Message("无法解析服务器返回的数据")
     */
    const DataException = 'DataException';

    /**
     * @HttpCode("500")
     * @Message("网络发生异常，无法连接服务器")
     */
    const NetworkException = 'NetworkException';

    /**
     * @HttpCode("401")
     * @Message("无效Token")
     */
    const Console_Connect_TokenInvalid = 'Console_Connect_TokenInvalid';

    /**
     * @HttpCode("401")
     * @Message("需要登录")
     */
    const Console_Login_NeedLogin = 'Console_Login_NeedLogin';


    public static function getHttpCode($code): ?int
    {
        try {
            return intval(self::__callStatic('getHttpCode', [$code]));
        } catch (ConstantsException $e) {
            return null;
        }
    }

    public static function getMessage($code): ?string
    {
        try {
            return self::__callStatic('getMessage', [$code]);
        } catch (ConstantsException $e) {
            return null;
        }
    }
}
