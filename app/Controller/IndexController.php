<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

namespace App\Controller;

use Hyperf\Di\Annotation\Inject;
use Hyperf\Cache\Listener\DeleteListenerEvent;
use Psr\EventDispatcher\EventDispatcherInterface;
use Hyperf\Paginator\Paginator;
class IndexController extends AbstractController
{
    /**
     * @Inject
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    public function index()
    {
        $user = $this->request->input('user', 'Hyperf');
        $method = $this->request->getMethod();


        $currentPage = $this->request->input('page', 1);
        $perPage = 2;
        $users = [
            ['id' => 1, 'name' => 'Tom'],
            ['id' => 2, 'name' => 'Sam'],
            ['id' => 3, 'name' => 'Tim'],
            ['id' => 4, 'name' => 'Joe'],
        ];
        return new Paginator($users, $perPage, $currentPage);


        //$this->dispatcher->dispatch(new DeleteListenerEvent('user-update', ['41115501874651137']));
        return [
            'method' => $method,
            'message' => "Hello {$user}.",
        ];
    }
}
