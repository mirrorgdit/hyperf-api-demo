<?php
declare(strict_types=1);

namespace App\Service;

use App\Model\User;
use Hyperf\Cache\Annotation\Cacheable;
use Hyperf\Cache\Annotation\CacheEvict;
use Hyperf\DbConnection\Db;
use Hyperf\Snowflake\IdGeneratorInterface;
use Hyperf\Utils\ApplicationContext;

class UserService
{
    /**
     * 登录验证
     * @param string $username
     * @param string $password
     * @return bool
     */
    public function login(string $username, string $password)
    {
        $user = User::where(['username' => $username, 'status' => 1])->select('uuid', 'password_hash')->first();
        if ($user === null) {
            return false;
        }
        //判断密码

        if (!$this->checkPassword($password, $user['password_hash'])) {
            return false;
        }
        return $user;
    }

    /**
     * @param array $registerInfo
     * @return array
     */
    public function register(array $registerInfo)
    {
        $user = new User();
        $user->uuid = $uuid = $this->getUuid();
        $user->username = $registerInfo['username'];
        $user->password_hash = $this->setPassword($registerInfo['password']);
        $user->nickname = $registerInfo['nickname'];
        $user->head_portrait = $registerInfo['head_portrait'] ?? '';
        $user->gender = $registerInfo['gender'];
        $user->qq = $registerInfo['qq'] ?? '';
        $user->email = $registerInfo['email'] ?? '';
        $user->birthday = $registerInfo['birthday'] ?? '';
        $user->mobile = $registerInfo['mobile'] ?? '';
        $user->last_time = time();
        $user->last_ip = $registerInfo['ip'] ?? '';
        $user->province_id = $registerInfo['province_id'] ?? 0;
        $user->city_id = $registerInfo['city_id'] ?? 0;
        $user->area_id = $registerInfo['area_id'] ?? 0;
        $user->status = 1;
        $user->created_at = time();
        $user->updated_at = time();
        //开启事务
        Db::beginTransaction();
        try {
            $user->save();
            Db::commit();
            return ['code' => 1, 'msg' => '注册成功', 'data' => $user];
        } catch (\Throwable $ex) {
            Db::rollBack();
            return ['code' => -1, 'msg' => $ex->getMessage()];
        }
    }


    /**
     * @Cacheable(prefix="user", ttl=6666, value="#{uuid}")
     *
     * @param string $uuid
     * @return array|null
     */
    public function info(string $uuid)
    {
        $user = User::select('uuid', 'username', 'nickname', 'realname', 'head_portrait', 'gender', 'gender', 'qq', 'email', 'birthday', 'mobile')->where('uuid', $uuid)->first();
        if ($user) {
            return $user->toArray();
        }
        return null;
    }

    /**
     *用户列表
     * @return array|null
     */
    public function list()
    {
        $user = User::select('uuid', 'username', 'nickname', 'realname', 'head_portrait', 'gender', 'gender', 'qq', 'email', 'birthday', 'mobile')->paginate(10);
        if ($user) {
            return $user->toArray();
        }
        return null;
    }

    /**
     * @CacheEvict(prefix="user", value="#{uuid}")
     *
     * 更新信息，更新后主动清理缓存 保证最新信息输出
     */
    public function doUpdate($updateInfo)
    {
        $user = User::query()->where('uuid', $updateInfo['id'])->first();
        $user->nickname = $updateInfo['nickname'];
        $user->gender = $updateInfo['gender'];
        $user->qq = $updateInfo['qq'] ?? '';
        $user->email = $updateInfo['email'] ?? '';
        $user->birthday = $updateInfo['birthday'] ?? '';
        $user->mobile = $updateInfo['mobile'] ?? '';
        $user->province_id = $updateInfo['province_id'] ?? 0;
        $user->city_id = $updateInfo['city_id'] ?? 0;
        $user->area_id = $updateInfo['area_id'] ?? 0;
        $user->updated_at = time();
        //开启事务
        Db::beginTransaction();
        try {
            $user->save();
            Db::commit();
            return ['code' => 1, 'msg' => '更改成功'];
        } catch (\Throwable $ex) {
            Db::rollBack();
            return ['code' => -1, 'msg' => $ex->getMessage()];
        }
    }

    /**
     * 生成hash密码
     * @param string $password
     * @return string
     */
    private function setPassword(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    /**
     * 验证密码
     * @param string $password
     * @param string $hash_password
     * @return bool
     */
    private function checkPassword(string $password, string $hash_password): bool
    {
        return password_verify($password, $hash_password);
    }

    /**
     * 生成唯一ID
     * @return mixed
     */
    private function getUuid()
    {
        $container = ApplicationContext::getContainer();
        $generator = $container->get(IdGeneratorInterface::class);
        return (string)$generator->generate();
    }


}