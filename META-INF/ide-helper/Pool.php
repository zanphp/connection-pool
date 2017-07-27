<?php

namespace Zan\Framework\Network\Connection;

use Zan\Framework\Contract\Network\ConnectionFactory;
use Zan\Framework\Contract\Network\ConnectionPool;
use Zan\Framework\Contract\Network\Connection;
use Zan\Framework\Utilities\Types\ObjectArray;

class Pool implements ConnectionPool
{
    public $waitNum = 0;

    public function __construct(ConnectionFactory $connectionFactory, array $config, $type)
    {

    }

    public function init()
    {

    }

    /**
     * @param string $previousConnectionHash
     * @param null $prevConn
     * @return null|void
     */
    public function createConnect($previousConnectionHash = '', $prevConn = null)
    {

    }

    /**
     * @return ObjectArray
     */
    public function getFreeConnection()
    {

    }

    /**
     * @return ObjectArray
     */
    public function getActiveConnection()
    {

    }

    public function reload(array $config)
    {
    }

    /**
     * @param null $connection
     * @return \Generator|void
     */
    public function get($connection = null)
    {

    }

    public function recycle(Connection $conn)
    {

    }

    public function remove(Connection $conn)
    {

    }

    /**
     * @return array|null
     */
    public function getPoolConfig()
    {

    }
}
