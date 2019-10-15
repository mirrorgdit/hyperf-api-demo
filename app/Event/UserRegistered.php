<?php
declare(strict_types=1);

namespace App\Event;

class UserRegistered
{
    // 建议这里定义成 public 属性，以便监听器对该属性的直接使用，或者你提供该属性的 Getter
    public $user;
    public $queueService;
    public function __construct($user,$queueService)
    {
        $this->user = $user;
        $this->queueService = $queueService;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return mixed
     */
    public function getQueueService()
    {
        return $this->queueService;
    }

}