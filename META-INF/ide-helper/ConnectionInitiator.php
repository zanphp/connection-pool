<?php

namespace Zan\Framework\Network\Connection;

class ConnectionInitiator
{
    private $ConnectionInitiator;

    public function __construct()
    {
        $this->ConnectionInitiator = new \ZanPHP\ConnectionPool\ConnectionInitiator();
    }

    public function init($directory, $server)
    {
        $this->ConnectionInitiator->init($directory, $server);
    }
}
