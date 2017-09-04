<?php

namespace Zan\Framework\Network\Connection;


use ZanPHP\Contracts\ConnectionPool\Connection;

class ConnectionEx implements Connection
{
    private $ConnectionEx;

    public function __construct($connEx, PoolEx $poolEx)
    {
        $this->ConnectionEx = new \ZanPHP\ConnectionPool\ConnectionEx($connEx,$poolEx);
    }

    public function getSocket()
    {
        $this->ConnectionEx->getSocket();
    }

    public function getEngine()
    {
        $this->ConnectionEx->getEngine();
    }

    public function getConfig()
    {
        $this->ConnectionEx->getConfig();
    }

    public function release()
    {
        $this->ConnectionEx->release();
    }

    public function close()
    {
        $this->ConnectionEx->close();
    }

    public function heartbeat() {
        $this->ConnectionEx->heartbeat();
    }
}