<?php

namespace Zan\Framework\Network\Connection\Factory;

use ZanPHP\ConnectionPool\Driver\Tcp as TcpConnection;
use ZanPHP\Contracts\ConnectionPool\ConnectionFactory;

class Tcp implements ConnectionFactory
{
    private $Tcp;

    public function __construct(array $config)
    {
        $this->Tcp = new \ZanPHP\ConnectionPool\Factory\Tcp($config);
    }

    public function create()
    {
        $this->Tcp->create();
    }

    public function getConnectTimeoutCallback(TcpConnection $connection)
    {
        $this->Tcp->getConnectTimeoutCallback($connection);
    }

    public function close()
    {
        $this->Tcp->close();
    }

}
