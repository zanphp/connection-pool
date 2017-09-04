<?php

namespace Zan\Framework\Network\Common;

use ZanPHP\Contracts\ConnectionPool\Connection;
use ZanPHP\Coroutine\Contract\Async;

class TcpClient implements Async
{
    private $TcpClient;

    public function __construct(Connection $conn)
    {
        $this->TcpClient = new \ZanPHP\ConnectionPool\TCP\TcpClient($conn);
    }

    public function execute(callable $callback, $task)
    {
        $this->TcpClient->execute($callback, $task);
    }

    public function recv($data)
    {
        $this->TcpClient->recv($data);
    }

    public function send($data)
    {
        $this->TcpClient->send($data);
    }
}