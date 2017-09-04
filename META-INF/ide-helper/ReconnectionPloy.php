<?php

namespace Zan\Framework\Network\Connection;


class ReconnectionPloy {

    private $ReconnectionPloy;

    public function __construct()
    {
        $this->ReconnectionPloy = new \ZanPHP\ConnectionPool\ReconnectionPloy();
    }

    public function init()
    {
        $this->ReconnectionPloy->init();
    }

    public function reconnect($conn, $pool)
    {
        $this->ReconnectionPloy->reconnect($conn, $pool);
    }

    public function connectSuccess($key)
    {
        $this->ReconnectionPloy->connectSuccess($key);
    }

    public function getReconnectTime($key)
    {
        $this->ReconnectionPloy->getReconnectTime($key);
    }

    public function setReconnectTime($key, $value)
    {
        $this->ReconnectionPloy->setReconnectTime($key, $value);
    }
}