<?php

namespace Zan\Framework\Network\Connection\Driver;


use Zan\Framework\Contract\Network\Connection;
use Zan\Framework\Contract\Network\ConnectionFactory;
use Zan\Framework\Contract\Network\ConnectionPool;


abstract class Base implements Connection
{
    abstract protected function closeSocket();

    public function setPool($pool)
    {

    }

    /**
     * @return ConnectionPool
     */
    public function getPool()
    {

    }

    public function setConfig($config)
    {

    }

    public function getConfig()
    {

    }

    /**
     * @return ConnectionFactory
     */
    public function getSocket()
    {

    }
    
    public function setSocket($socket)
    {

    }

    public function unsetSocket()
    {

    }

    public function setUnReleased()
    {

    }

    public function release()
    {

    }
    
    public function close()
    {

    }

    public function heartbeat()
    {
    }

    public function setEngine($engine)
    {

    }

    public function getEngine()
    {

    }

    public function setIsAsync($isAsync)
    {

    }

    public function getIsAsync() {

    }

    public function getConnectTimeoutJobId()
    {

    }

    public function onConnectTimeout()
    {

    }

    /**
     * @return string
     */
    public function getConnString()
    {

    }
}