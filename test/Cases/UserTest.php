<?php


namespace HyperfTest\Cases;

use HyperfTest\HttpTestCase;
use App\Service\UserService;

/**
 * @internal
 * @coversNothing
 */
class UserTest extends HttpTestCase
{
    public function testUserServiceInfo()
    {
        $model = \Hyperf\Utils\ApplicationContext::getContainer()->get(UserService::class)->info('41115501874651137');

        var_dump($model);

        $this->assertSame('41115501874651137', $model['uuid']);
    }
}