<?php
declare(strict_types=1);


return [
    'host' => env('EMIAL_HOST', 'smtp.163.com'), // SMTP服务器地址
    'port' => env('EMIAL_PORT', '25'), // SMTP服务器端口号,一般为25
    'addr' => env('EMIAL_ADDR', ''), // 发件邮箱地址
    'pass' => env('EMIAL_PASS', ''), // 发件邮箱密码
    'name' => '发件邮箱名称', // 发件邮箱名称
    'subject' => '发件邮箱标题',//发件邮箱标题主题
];