<?php

declare(strict_types=1);

namespace App\Job;

use App\Log;
use Hyperf\AsyncQueue\Job;

class LogRecordJob extends Job
{
    public $params;

    public function __construct($params)
    {
        // 这里最好是普通数据，不要使用携带 IO 的对象，比如 PDO 对象
        $this->params = $params;
    }

    public function handle()
    {
        // 根据参数处理具体逻辑
        // 日志
        $log = new Log();
        $logger = $log->get('api');
        $str = "\r\n请求接口:".$this->params['url']."\r\n请求参数:".json_encode($this->params['requestData'])."\r\n应答结果:".json_encode($this->params['responseData']);
        $logger->info($str);
        return true;

    }
}