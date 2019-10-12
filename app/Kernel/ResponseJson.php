<?php

declare(strict_types=1);

namespace App\Kernel;

use Hyperf\Utils\Contracts\Jsonable;

class ResponseJson implements Jsonable
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function __toString(): string
    {
        $json = json_encode($this->data, JSON_UNESCAPED_UNICODE);
        $json = preg_replace('/,\s*"[^"]+":null|"[^"]+":null,?/', '', $json);
        return $json;
    }
}
