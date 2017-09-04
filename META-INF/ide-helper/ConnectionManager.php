<?php

namespace Zan\Framework\Network\Connection;


class ConnectionManager
{
    private $ConnectionManager;

    public function __construct()
    {
        $this->ConnectionManager = new \ZanPHP\ConnectionPool\ConnectionManager();
    }

    public function get($connKey)
    {
        $this->ConnectionManager->get($connKey);
    }

    public function addPool($poolKey, $pool)
    {
        $this->ConnectionManager->addPool($poolKey, $pool);
    }

    public function monitor()
    {
        $this->ConnectionManager->monitor();
    }

    public function monitorTick()
    {
        $this->ConnectionManager->monitorTick();
    }

    public function setServer($server)
    {
        $this->ConnectionManager->setServer($server);
    }

    public function monitorConnectionNum()
    {
        $this->ConnectionManager->monitorConnectionNum();
    }
}
