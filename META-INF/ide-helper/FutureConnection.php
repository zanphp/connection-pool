<?php

namespace Zan\Framework\Network\Connection;

use ZanPHP\Coroutine\Contract\Async;

class FutureConnection implements Async
{
    private $FutureConnection;

    public function __construct($connectionManager, $connKey, $timeout, $pool)
    {
        $this->FutureConnection = new \ZanPHP\ConnectionPool\FutureConnection($connectionManager, $connKey, $timeout, $pool);
    }

    public function execute(callable $callback, $task)
    {
        $this->FutureConnection->execute($callback, $task);
    }

    public function getConnection()
    {
        $this->FutureConnection->getConnection();
    }

    public function doGeting()
    {
        $this->FutureConnection->doGeting();
    }

    public function onConnectTimeout()
    {
        $this->FutureConnection->onConnectTimeout();
    }
}