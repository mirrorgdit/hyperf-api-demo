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

        //$this->dispatcher->dispatch(new DeleteListenerEvent('user-update', ['41115501874651137']));
        return [
            'method' => $method,
            'message' => "Hello {$user}.",
        ];
    }
}
