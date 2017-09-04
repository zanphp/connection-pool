<?php

namespace Zan\Framework\Network\Connection\Factory;

use ZanPHP\ConnectionPool\Driver\Mysql as MysqlConnection;
use ZanPHP\Contracts\ConnectionPool\ConnectionFactory;

class Mysql implements ConnectionFactory
{
    private $Mysql;

    public function __construct(array $config)
    {
        $this->Mysql = new \ZanPHP\ConnectionPool\Factory\Mysql($config);
    }

    public function create()
    {
        $this->Mysql->create();
    }

    public function getConnectTimeoutCallback(MysqlConnection $connection)
    {
        $this->Mysql->getConnectTimeoutCallback($connection);
    }

    public function close()
    {
        $this->Mysql->close();
    }
}