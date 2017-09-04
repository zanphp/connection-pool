<?php

namespace Zan\Framework\Network\Connection;

use ZanPHP\Contracts\ConnectionPool\Connection;
use ZanPHP\Contracts\ConnectionPool\ConnectionFactory;
use ZanPHP\Contracts\ConnectionPool\ConnectionPool;

class Pool implements ConnectionPool
{
    private $Pool;

    public function __construct(ConnectionFactory $connectionFactory, array $config, $type)
    {
        $this->Pool = new \ZanPHP\ConnectionPool\Pool($connectionFactory, $config, $type);
    }

    public function init()
    {
        $this->Pool->init();
    }

    public function createConnect($previousConnectionHash = '', $prevConn = null)
    {
        $this->Pool->createConnect($previousConnectionHash, $prevConn);
    }

    public function getFreeConnection()
    {
        $this->Pool->getFreeConnection();
    }

    public function getActiveConnection()
    {
        $this->Pool->getActiveConnection();
    }

    public function reload(array $config)
    {
        $this->Pool->reload($config);
    }

    public function get($connection = null)
    {
        $this->Pool->get($connection);
    }

    public function recycle(Connection $conn)
    {
        $this->Pool->recycle($conn);
    }

    public function remove(Connection $conn)
    {
        $this->Pool->remove($conn);
    }

    public function getPoolConfig()
    {
        $this->Pool->getPoolConfig();
    }
}
