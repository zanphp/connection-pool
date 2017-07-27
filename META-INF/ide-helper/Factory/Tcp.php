<?php

namespace Zan\Framework\Network\Connection\Factory;

use Zan\Framework\Contract\Network\ConnectionFactory;
use swoole_client as SwooleClient;
use Zan\Framework\Network\Connection\Driver\Tcp as TcpConnection;

class Tcp implements ConnectionFactory
{
    public function __construct(array $config)
    {

    }

    public function create()
    {

    }

    public function getConnectTimeoutCallback(TcpConnection $connection)
    {

    }

    public function close()
    {

    }

}
