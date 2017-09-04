<?php

namespace Zan\Framework\Network\Connection\Driver;

use ZanPHP\Contracts\ConnectionPool\Base;
use ZanPHP\Contracts\ConnectionPool\Connection;

class Mysql extends Base implements Connection
{
    private $Mysql;

    public function __construct()
    {
        $this->Mysql = new \ZanPHP\ConnectionPool\Driver\Mysql();
    }

    public function closeSocket()
    {
        $this->Mysql->closeSocket();
    }

    public function init() {
        $this->Mysql->init();
    }

    public function onConnect(\swoole_mysql $cli, $result)
    {
        $this->Mysql->onConnect($cli, $result);
    }

    public function onClose(\swoole_mysql $cli)
    {
        $this->Mysql->onClose($cli);
    }

    public function onError(\swoole_mysql $cli)
    {
        $this->Mysql->onError($cli);
    }

    public function close()
    {
        $this->Mysql->close();
    }

    public function heartbeat()
    {
        $this->Mysql->heartbeat();
    }

    public function heartbeatLater()
    {
        $this->Mysql->heartbeatLater();
    }

    public function heartbeating()
    {
        $this->Mysql->heartbeating();
    }

    public function ping()
    {
        $this->Mysql->ping();
    }
}