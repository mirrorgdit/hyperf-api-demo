<?php

declare(strict_types=1);

namespace App\Service;

use App\Job\EmailJob;
use App\Job\LogRecordJob;
use Hyperf\AsyncQueue\Driver\DriverFactory;
use Hyperf\AsyncQueue\Driver\DriverInterface;

class QueueService
{
    /**
     * @var DriverInterface
     */
    protected $driver;

    public function __construct(DriverFactory $driverFactory)
    {
        $this->driver = $driverFactory->get('default');
    }

    /**
     * 生产消息.
     * @param $params 数据
     * @param int $delay 延时时间 单位秒
     */
    public function push($params, int $type = 0, int $delay = 0): bool
    {
        // 这里的 `EmailJob` 会被序列化存到 Redis 中，所以内部变量最好只传入普通数据
        // 同理，如果内部使用了注解 @Value 会把对应对象一起序列化，导致消息体变大。
        // 所以这里也不推荐使用 `make` 方法来创建 `Job` 对象。
        if ($type == 0) {
            $jobParams['email'] =$params['data']['email'];
            $jobParams['nickname'] =$params['data']['nickname'];
            return $this->driver->push(new EmailJob($jobParams), $delay);
        } else {
            return $this->driver->push(new LogRecordJob($params), $delay);

        }
    }
}