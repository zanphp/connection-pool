<?php

namespace Zan\Framework\Network\Connection;



use Zan\Framework\Network\Connection\Factory\NovaClient;
use Zan\Framework\Utilities\DesignPattern\Singleton;


class ConnectionInitiator
{
    use Singleton;

    const CONNECT_TIMEOUT = 1000;
    const CONCURRENCY_CONNECTION_LIMIT = 50;

    const HEARTBEAT_INTERVAL = 15 * 1000;
    const HEARTBEAT_TIMEOUT = 1000;

    /**
     * @param $directory
     */
    public function init($directory, $server)
    {

    }
}
