<?php

namespace Zan\Framework\Network\Connection\Factory;

use swoole_client as SwooleClient;
use Zan\Framework\Contract\Network\ConnectionFactory;
use Zan\Framework\Network\Connection\Driver\Syslog as SyslogDriver;

class Syslog implements ConnectionFactory
{
    public function __construct(array $config)
    {

    }

    public function create()
    {

    }

    public function getConnectTimeoutCallback(SyslogDriver $connection)
    {

    }

    public function close()
    {

    }

}
