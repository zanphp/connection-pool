<?php

namespace Zan\Framework\Network\Connection\Driver;

use Zan\Framework\Contract\Network\Connection;
use swoole_client as SwooleClient;

class Tcp extends Base implements Connection
{
    public function closeSocket()
    {

    }

    public function init()
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
}