<?php

namespace Zan\Framework\Network\Connection\Driver;


use Zan\Framework\Contract\Network\Connection;

class Mysql extends Base implements Connection
{
    public function closeSocket()
    {

    }

    public function init() {
        $this->classHash = spl_object_hash($this);
    }

    public function onConnect(\swoole_mysql $cli, $result)
    {

    }

    public function onClose(\swoole_mysql $cli)
    {

    }

    public function onError(\swoole_mysql $cli)
    {

    }

    public function close()
    {

    }

    public function heartbeat()
    {

    }

    public function heartbeatLater()
    {

    }

    public function heartbeating()
    {

    }

    public function ping()
    {

    }
}