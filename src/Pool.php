<?php

namespace ZanPHP\ConnectionPool;

use ZanPHP\Contracts\ConnectionPool\Connection;
use ZanPHP\Contracts\ConnectionPool\ConnectionFactory;
use ZanPHP\Contracts\ConnectionPool\ConnectionPool;
use ZanPHP\Coroutine\StaticEvent;
use ZanPHP\Support\ObjectArray;
use ZanPHP\Support\Time;

class Pool implements ConnectionPool
{
    /**
     * @var ObjectArray
     */
    private $freeConnection = null;

    /**
     * @var ObjectArray
     */
    private $activeConnection = null;

    private $poolConfig = null;

    private $factory = null;

    private $type = null;

    public $waitNum = 0;

    public function __construct(ConnectionFactory $connectionFactory, array $config)
    {
        $this->poolConfig = $config;
        $this->factory = $connectionFactory;
        $this->type = $connectionFactory->getFactoryType();
        $this->init();
    }

    public function init()
    {
        $initConnection = $this->poolConfig['pool']['init-connection'];
        $min = isset($this->poolConfig['pool']['minimum-connection-count']) ?
            $this->poolConfig['pool']['minimum-connection-count'] : 2;
        if ($initConnection < $min) {
            $initConnection = $min;
        }
        $this->freeConnection = new ObjectArray();
        $this->activeConnection = new ObjectArray();
        for ($i = 0; $i < $initConnection; $i++) {
            $this->createConnect();
        }
    }

    public function createConnect($previousConnectionHash = '', $prevConn = null)
    {
        $max = isset($this->poolConfig['pool']['maximum-connection-count']) ?
            $this->poolConfig['pool']['maximum-connection-count'] : 30;
        $sumCount = $this->activeConnection->length() + $this->freeConnection->length();
        if($sumCount >= $max) {
            return null;
        }
        $connection = $this->factory->create();
        if (null === $connection) {
            return;
        }

        if  ('' !== $previousConnectionHash) {
            $previousKey = ReconnectionPloy::getInstance()->getReconnectTime($previousConnectionHash);
            if ($this->type == 'Mysqli') {

                $errno = 0;
                if (null !== $prevConn) {
                    $sock = $prevConn->getSocket();
                    $errno = $sock->connect_errno;
                }

                if ($errno) {
                    ReconnectionPloy::getInstance()->setReconnectTime(spl_object_hash($connection),$previousKey);
                    $this->freeConnection->remove($prevConn);
                    $this->activeConnection->remove($prevConn);
                }

                $connection->setPool($this);
            } else {
                ReconnectionPloy::getInstance()->setReconnectTime(spl_object_hash($connection), $previousKey);
            }
            ReconnectionPloy::getInstance()->connectSuccess($previousConnectionHash);
        }

        if ($connection->getIsAsync()) {
            $this->activeConnection->push($connection);
        } else {
            $this->freeConnection->push($connection);
        }
        if ('' == $previousConnectionHash) {
            if ($this->type !== 'Mysqli') {
                $connection->heartbeat();
            }
        }
        $connection->setPool($this);
        $connection->setEngine($this->type);
    }

    /**
     * @return ObjectArray
     */
    public function getFreeConnection()
    {
        return $this->freeConnection;
    }

    /**
     * @return ObjectArray
     */
    public function getActiveConnection()
    {
        return $this->activeConnection;
    }

    public function reload(array $config)
    {
    }

    public function get()
    {
        if ($this->freeConnection->isEmpty()) {
            $this->createConnect();
        }

        $connection = $this->freeConnection->pop();
        if (null != $connection) {
            $this->activeConnection->push($connection);
        } else {
            yield new FutureConnection($this->poolConfig['pool']['pool_name'], $this->poolConfig["connect_timeout"], $this);
            return;
        }

        $connection->setUnReleased();
        $connection->lastUsedTime = Time::current(true);
        yield $connection;
    }

    public function recycle(Connection $conn)
    {
        $evtName = null;

        $this->freeConnection->push($conn);
        $this->activeConnection->remove($conn);

        $evtName = $this->poolConfig['pool']['pool_name'] . '_free';
        StaticEvent::fire($evtName, [], false);
    }

    public function remove(Connection $conn)
    {
        $this->freeConnection->remove($conn);
        $this->activeConnection->remove($conn);
        $connHashCode = spl_object_hash($conn);
        if (null === ReconnectionPloy::getInstance()->getReconnectTime($connHashCode)) {
            ReconnectionPloy::getInstance()->setReconnectTime($connHashCode, 0);
            $this->createConnect($connHashCode, $conn);
            return;
        }

        ReconnectionPloy::getInstance()->reconnect($conn, $this);
    }

    /**
     * @return array|null
     */
    public function getPoolConfig()
    {
        return $this->poolConfig;
    }
}
