<?php

namespace Zan\Framework\Network\Connection\Factory;

use Zan\Framework\Contract\Network\ConnectionFactory;
use Zan\Framework\Network\Connection\Driver\Mysql as MysqlConnection;

class Mysql implements ConnectionFactory
{
    const DEFAULT_CHARSET = "utf8mb4";


    public function __construct(array $config)
    {

    }

    public function create()
    {

    }

    public function getConnectTimeoutCallback(MysqlConnection $connection)
    {

    }

    public function close()
    {

    }
}