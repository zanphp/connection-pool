<?php

namespace Zan\Framework\Network\Common;

use Zan\Framework\Foundation\Contract\Async;
use Zan\Framework\Network\Connection\ConnectionEx;

class TcpClientEx implements Async
{
    const DEFAULT_SEND_TIMEOUT = 3000;

    public function __construct(ConnectionEx $conn)
    {

    }

    public function execute(callable $callback, $task)
    {

    }

    public function send($data)
    {

    }

    public function recv(\swoole_client $client, $r)
    {

    }
}