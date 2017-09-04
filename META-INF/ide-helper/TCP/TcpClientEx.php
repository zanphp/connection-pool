<?php

namespace Zan\Framework\Network\Common;

use ZanPHP\ConnectionPool\ConnectionEx;
use ZanPHP\Coroutine\Contract\Async;

class TcpClientEx implements Async
{
    private $TcpClientEx;

    public function __construct(ConnectionEx $conn)
    {
        $this->TcpClientEx = new \ZanPHP\ConnectionPool\TCP\TcpClientEx($conn);
    }

    public function execute(callable $callback, $task)
    {
        $this->TcpClientEx->execute($callback, $task);
    }

    public function send($data)
    {
        $this->TcpClientEx->send($data);
    }

    public function recv(\swoole_client $client, $r)
    {
        $this->TcpClientEx->recv($client, $r);
    }
}