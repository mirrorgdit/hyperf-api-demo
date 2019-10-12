<?php

declare(strict_types=1);

namespace App\Job;

use Hyperf\AsyncQueue\Job;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class EmailJob extends Job
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
        //发邮件
        $toEmail = $this->params['email'];
        $toUsername = $this->params['nickname'];

        $username = config('email.addr');
        $password = config('email.pass');
        // Create the Transport
        $transport = (new Swift_SmtpTransport(config('email.host'), config('email.port')))
            ->setUsername($username)
            ->setPassword($password);

        // Create the Mailer using your created Transport
        $mailer = new Swift_Mailer($transport);

        // Create a message
        $message = (new Swift_Message(config('email.subject')))
            ->setFrom([$username => config('email.name')])
            ->setTo([$toEmail => $toUsername])
            ->setBody('感谢您注册 Hyperf-Api案例系统,即刻起您将成为我们优质的客户！');

        // Send the message
        $mailer->send($message);
        return true;

    }
}