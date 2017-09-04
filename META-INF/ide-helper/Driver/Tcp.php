<?php

namespace Zan\Framework\Network\Connection\Driver;

use swoole_client as SwooleClient;
use ZanPHP\Contracts\ConnectionPool\Base;
use ZanPHP\Contracts\ConnectionPool\Connection;


class Tcp extends Base implements Connection
{
    private $Tcp;

    public function __construct()
    {
        $this->Tcp = new \ZanPHP\ConnectionPool\Driver\Tcp();
    }

    public function closeSocket()
    {
        $this->Tcp->closeSocket();
    }

    public function init()
    {
        $this->Tcp->init();
    }

    public function onConnect($cli)
    {
        $this->Tcp->onConnect($cli);
    }

    public function onClose(SwooleClient $cli)
    {
        $this->Tcp->onClose($cli);
    }

    public function onReceive(SwooleClient $cli, $data)
    {
        $this->Tcp->onReceive($cli, $data);
    }

    public function onError(SwooleClient $cli)
    {
        $this->Tcp->onError($cli);
    }

    public function setClientCb(callable $cb)
    {
        $this->Tcp->setClientCb($cb);
    }
}