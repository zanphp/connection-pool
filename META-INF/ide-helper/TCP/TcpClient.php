<?php

namespace Zan\Framework\Network\Common;

use Zan\Framework\Foundation\Contract\Async;
use Zan\Framework\Contract\Network\Connection;

class TcpClient implements Async
{
    public function __construct(Connection $conn)
    {

    }

    public function execute(callable $callback, $task)
    {

    }

    public function recv($data)
    {

    }

    public function send($data)
    {

    }
}