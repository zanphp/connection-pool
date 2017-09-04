<?php

namespace Zan\Framework\Network\Connection\Driver;

use swoole_client as SwooleClient;
use ZanPHP\Contracts\ConnectionPool\Base;
use ZanPHP\Contracts\ConnectionPool\Connection;

class Syslog extends Base implements Connection
{
    private $Syslog;

    public function __construct()
    {
        $this->Syslog = new \ZanPHP\ConnectionPool\Driver\Syslog();
    }

    public function init()
    {
        $this->Syslog->init();
    }

    public function send($log)
    {
        $this->Syslog->send($log);
    }

    public function onConnect($cli)
    {
        $this->Syslog->onConnect($cli);
    }

    public function onClose(SwooleClient $cli)
    {
        $this->Syslog->onClose($cli);
    }

    public function onReceive(SwooleClient $cli, $data)
    {
        $this->Syslog->onReceive($cli, $data);
    }

    public function onError(SwooleClient $cli)
    {
        $this->Syslog->onError($cli);
    }

    public function setClientCb(callable $cb)
    {
        $this->Syslog->setClientCb($cb);
    }

    public function closeSocket()
    {
        $this->Syslog->closeSocket();
    }
}
