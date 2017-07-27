<?php

namespace Zan\Framework\Network\Connection\Driver;

use swoole_client as SwooleClient;
use Zan\Framework\Contract\Network\Connection;

class Syslog extends Base implements Connection
{
    public function init()
    {

    }

    public function send($log)
    {

    }

    public function onConnect($cli)
    {

    }

    public function onClose(SwooleClient $cli)
    {

    }

    public function onReceive(SwooleClient $cli, $data)
    {

    }

    public function onError(SwooleClient $cli)
    {

    }

    public function setClientCb(callable $cb)
    {

    }

    public function closeSocket()
    {

    }
}
