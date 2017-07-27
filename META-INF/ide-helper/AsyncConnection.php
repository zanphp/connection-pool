<?php

namespace Zan\Framework\Network\Connection;


use Zan\Framework\Foundation\Contract\Async;

class AsyncConnection implements Async
{
    public function __construct(PoolEx $poolEx)
    {
        $this->poolEx = $poolEx;
    }

    public function __invoke(\swoole_connpool $pool, $connEx)
    {

    }

    public function execute(callable $callback, $task)
    {

    }
}