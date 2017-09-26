<?php
/**
 * Created by PhpStorm.
 * User: huye
 * Date: 2017/9/18
 * Time: 上午11:43
 */

namespace ZanPHP\ConnectionPool\Tests;

use ZanPHP\ConnectionPool\ConnectionManager;
use ZanPHP\ConnectionPool\ConnectionInitiator;
use ZanPHP\ConnectionPool\Driver\Mysql;
use ZanPHP\ConnectionPool\Driver\Redis;
use ZanPHP\ConnectionPool\Driver\Syslog;
use ZanPHP\ConnectionPool\Driver\Tcp;

class ConnectionPoolTest extends TaskTestCase {

    public function taskPoolWork()
    {
        ConnectionInitiator::getInstance()->init('connection', null);
        $conn_mysql = (yield ConnectionManager::getInstance()->get('mysql.default_write',false));
        $this->assertInstanceOf(Mysql::class,$conn_mysql,'mysql connection get failed');
        $conn_mysql->close();

        $conn_redis = (yield ConnectionManager::getInstance()->get('redis.default_write',false));
        $conn_redis->close();
        $this->assertInstanceOf(Redis::class,$conn_redis,'redis connection get failed');

        $conn_syslog = (yield ConnectionManager::getInstance()->get('syslog.syslog_default',false));
        $this->assertInstanceOf(Syslog::class,$conn_syslog,'syslog connection get failed');
        $conn_syslog->close();

        $conn_tcp= (yield ConnectionManager::getInstance()->get('tcp.trace',false));
        $this->assertInstanceOf(Tcp::class,$conn_tcp,'tcp connection get failed');
        $conn_tcp->close();
    }
}