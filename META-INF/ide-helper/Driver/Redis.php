<?php

namespace Zan\Framework\Network\Connection\Driver;

use ZanPHP\Contracts\ConnectionPool\Base;
use ZanPHP\Contracts\ConnectionPool\Connection;

class Redis extends Base implements Connection
{
    private $Redis;

    public function __construct()
    {
        $this->Redis = new \ZanPHP\ConnectionPool\Driver\Redis();
    }

    public function closeSocket()
    {
        $this->Redis->closeSocket();
    }

    public function init()
    {
        $this->Redis->init();
    }

    public function onClose($redis)
    {
        $this->Redis->onClose($redis);
    }

    public function onConnect($redis, $res)
    {
        $this->Redis->onConnect($redis, $res);
    }

    public function onMessage($redis, $message)
    {
        $this->Redis->onMessage($redis, $message);
    }

}