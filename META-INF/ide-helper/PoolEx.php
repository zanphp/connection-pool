<?php

namespace Zan\Framework\Network\Connection;

use Zan\Framework\Foundation\Exception\ZanException;

class PoolEx
{
    public $poolType;

    /**
     * @var \swoole_connpool
     */
    public $poolEx;

    public $config;

    public $typeMap = [
        'Mysqli'    => \swoole_connpool::SWOOLE_CONNPOOL_MYSQL,
        'Redis'     => \swoole_connpool::SWOOLE_CONNPOOL_REDIS,
        'Tcp'       => \swoole_connpool::SWOOLE_CONNPOOL_TCP,
        'Syslog'    => \swoole_connpool::SWOOLE_CONNPOOL_TCP,
    ];

    public static $engineMapEx = ['Mysqli', 'Redis', 'Tcp', 'Syslog'];

    public static function support($factoryType)
    {

    }

    public function __construct($factoryType, array $config)
    {

    }

    public function get()
    {
        $asyncConn = new AsyncConnection($this);

        $timeout = $this->config["pool"]["get-timeout"];
        $r = $this->poolEx->get($timeout, $asyncConn);
        if ($r === false) {
            throw new ZanException("get connection fail [pool=$this->poolType]");
        }

        yield $asyncConn;
    }

    public function release($conn, $close = false)
    {
        if ($close) {
            return $this->poolEx->release($conn, \swoole_connpool::SWOOLE_CONNNECT_ERR);
        } else {
            return $this->poolEx->release($conn, \swoole_connpool::SWOOLE_CONNNECT_OK);
        }
    }

    public function getStatInfo()
    {
        $info = $this->poolEx->getStatInfo();

        return [
            "all" => $info["all_conn_obj"],
            "active" => $info["all_conn_obj"] - $info["idle_conn_obj"],
            "free" => $info["idle_conn_obj"],
        ];
    }
}