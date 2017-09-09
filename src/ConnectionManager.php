<?php

namespace ZanPHP\ConnectionPool;

use InvalidArgumentException;
use ZanPHP\ConnectionPool\Exception\CanNotCreateConnectionException;
use ZanPHP\ConnectionPool\Exception\ConnectTimeoutException;
use ZanPHP\ConnectionPool\Exception\GetConnectionTimeoutFromPool;
use ZanPHP\Container\Container;
use ZanPHP\Contracts\Config\Repository;
use ZanPHP\Contracts\ConnectionPool\Connection;
use ZanPHP\Contracts\Hawk\Hawk;
use ZanPHP\Coroutine\Condition;
use ZanPHP\Coroutine\Exception\ConditionException;
use ZanPHP\Exception\ZanException;
use ZanPHP\Hawk\Constant;
use ZanPHP\Support\Singleton;
use ZanPHP\Timer\Timer;
use ZanPHP\Contracts\ConnectionPool\ConnectionManager as ConnectionManagerContract;

class ConnectionManager implements ConnectionManagerContract
{

    use Singleton;

    /**
     * @var Pool[]
     */
    private static $poolMap = [];

    /**
     * @var PoolEx[]
     */
    private static $poolExMap = [];

    private static $server;

    public static $getPoolEvent = "getPoolEvent";

    /**
     * @param string $connKey
     * @return \Zan\Framework\Contract\Network\Connection
     * @throws InvalidArgumentException | CanNotCreateConnectionException | ConnectTimeoutException
     */
    public function get($connKey, $wait = true)
    {
        while (!isset(self::$poolMap[$connKey]) && !isset(self::$poolExMap[$connKey])) {
            if (!$wait) {
                throw new ZanException("Trace/Syslog can not find poolMap, ignore it");
            }
            try {
                yield new Condition(static::$getPoolEvent, 300);
            } catch (ConditionException $e) {
                sys_error("poolName: $connKey condition wait timeout");
            }
        }

        if (isset(self::$poolExMap[$connKey])) {
            yield $this->getFromPoolEx($connKey);
        } else if(isset(self::$poolMap[$connKey])){
            yield $this->getFromPool($connKey);
        } else {
            throw new InvalidArgumentException('No such ConnectionPool:'. $connKey);
        }
    }

    private function getFromPool($connKey)
    {
        $pool = self::$poolMap[$connKey];

        $conf = $pool->getPoolConfig();
        $maxWaitNum = $conf['pool']['maximum-wait-connection'];
        if ($pool->waitNum > $maxWaitNum) {
            throw new CanNotCreateConnectionException("Connection $connKey has up to the maximum waiting connection number");
        }

        $connection = (yield $pool->get());

        if ($connection instanceof Connection) {
            yield $connection;
        } else {
            yield new FutureConnection($this, $connKey, $conf["connect_timeout"], $pool);
        }
    }

    private function getFromPoolEx($connKey)
    {
        $pool = self::$poolExMap[$connKey];
        $connection = (yield $pool->get());

        if ($connection instanceof Connection) {
            yield $connection;
        } else {
            throw new GetConnectionTimeoutFromPool("get connection $connKey timeout");
        }
    }

    /**
     * @param $poolKey
     * @param Pool|PoolEx $pool
     * @throws InvalidArgumentException
     */
    public function addPool($poolKey, $pool)
    {
        if ($pool instanceof Pool) {
            self::$poolMap[$poolKey] = $pool;
        } else if ($pool instanceof PoolEx) {
            self::$poolExMap[$poolKey] = $pool;
        } else {
            throw new InvalidArgumentException("invalid pool type, poolKey=$poolKey");
        }
    }

    public function monitor()
    {
        Timer::tick(30 * 1000, function() {
            foreach (self::$poolExMap as $poolKey => $pool) {
                $info = $pool->getStatInfo();
                $all = $info["all"];
                $free = $info["free"];
                sys_echo("pool_ex info [type=$poolKey, all=$all, free=$free]");
            };
        });

        $repository = make(Repository::class);
        $config = $repository->get('hawk');
        if (!$config['run']) {
            return;
        }
        $time = $config['time'];
        Timer::tick($time, [$this, 'monitorTick']);
    }

    public function monitorTick()
    {
        $container = Container::getInstance();
        $hawk = $container->make(Hawk::class);

        foreach (self::$poolMap as $poolKey => $pool) {
            $activeNums = $pool->getActiveConnection()->length();
            $freeNums = $pool->getFreeConnection()->length();

            $hawk->add(Constant::BIZ_CONNECTION_POOL,
                [
                    'free'  => $freeNums,
                    'active' => $activeNums,
                ], [
                    'pool_name' => $poolKey,
                ]
            );
        }

        foreach (self::$poolExMap as $poolKey => $pool) {
            $hawk->add(Constant::BIZ_CONNECTION_POOL, $pool->getStatInfo(), [
                    'pool_name' => $poolKey,
                ]
            );
        }
    }

    public function setServer($server)
    {
        self::$server = $server;
    }

    public function monitorConnectionNum()
    {
        MonitorConnectionNum::getInstance()->controlLinkNum(self::$poolMap);
    }
}
