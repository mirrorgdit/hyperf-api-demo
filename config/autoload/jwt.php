<?php
declare(strict_types=1);

return [
    'key' => env('JWT_KEY'),
    'alg' => env('JWT_ALG'),
    'exp' => env('JWT_EXP'),
];