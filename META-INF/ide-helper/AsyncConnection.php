<?php

namespace Zan\Framework\Network\Connection;


use ZanPHP\Coroutine\Contract\Async;

class AsyncConnection implements Async
{
    private $AsyncConnection;

    public function __construct(PoolEx $poolEx)
    {
        $this->AsyncConnection = new \ZanPHP\ConnectionPool\AsyncConnection($poolEx);
    }

    public function __invoke(\swoole_connpool $pool, $connEx)
    {
        $this->AsyncConnection->__invoke($pool, $connEx);
    }

    public function execute(callable $callback, $task)
    {
        $this->AsyncConnection->execute($callback, $task);
    }
}