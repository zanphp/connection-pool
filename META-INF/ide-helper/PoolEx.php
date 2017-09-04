<?php

namespace Zan\Framework\Network\Connection;


class PoolEx
{
    private $PoolEx;

    public function __construct($factoryType, array $config)
    {
        $this->PoolEx = new \ZanPHP\ConnectionPool\PoolEx($factoryType,$config);
    }

    public static function support($factoryType)
    {
        \ZanPHP\ConnectionPool\PoolEx::support($factoryType);
    }

    public function get()
    {
        $this->PoolEx->get();
    }

    public function release($conn, $close = false)
    {
        $this->PoolEx->release($conn, $close);
    }

    public function getStatInfo()
    {
        $this->PoolEx->getStatInfo();
    }
}