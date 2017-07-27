<?php


namespace Zan\Framework\Network\Connection\Factory;

use Zan\Framework\Contract\Network\ConnectionFactory;
use swoole_redis as SwooleRedis;
use \Zan\Framework\Network\Connection\Driver\Redis as Client;

class Redis implements ConnectionFactory
{
    public function __construct(array $config)
    {

    }
    
    public function create()
    {

    }

    public function getConnectTimeoutCallback(Client $connection)
    {

    }

    public function close()
    {
    }

}