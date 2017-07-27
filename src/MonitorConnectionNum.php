<?php

namespace ZanPHP\ConnectionPool;

use ZanPHP\Contracts\Config\Repository;
use ZanPHP\Support\Singleton;
use ZanPHP\Support\Time;
use ZanPHP\Timer\Timer;

class MonitorConnectionNum {

    use Singleton;

    private static $poolMap=[];

    public function controlLinkNum($poolMap)
    {
        self::$poolMap = $poolMap;
        $repository = make(Repository::class);
        $config = $repository->get('reconnection');
        $time = isset($config['interval-reduce-link'])?  $config['interval-reduce-link'] : 60000;
        Timer::tick($time, [$this, 'reduceLinkNum']);
    }

    public function reduceLinkNum()
    {
        $repository = make(Repository::class);
        $config = $repository->get('reconnection');
        $timeInterval = isset($config['interval-reduce-link'])?  $config['interval-reduce-link'] : 60000;
        foreach (self::$poolMap as $poolKey => $pool) {
            $activeNum = $pool->getActiveConnection()->length();
            $freeNum = $pool->getFreeConnection()->length();
            $sumNum = $activeNum + $freeNum;
            if ($sumNum <=0) {
                continue;
            }
            $poolConfig = $repository->get('connection.' . $poolKey)['pool'];
            $minConnectionNum = isset($poolConfig['minimum-connection-count']) ? $poolConfig['minimum-connection-count'] : 1;
            if ($freeNum <= $minConnectionNum) {
                continue;
            }
            for ($i=0; $i<$freeNum-$minConnectionNum; $i++) {
                $conn = $pool->getFreeConnection()->pop();
                if ($conn->lastUsedTime == 0 || (Time::current(true) - $conn->lastUsedTime) > $timeInterval/1000) {
                    $conn->closeSocket();
                } else {
                    $pool->getFreeConnection()->push($conn);
                }
            }
        }
    }
}