<?php

namespace ZanPHP\ConnectionPool\Driver;

use ZanPHP\Contracts\ConnectionPool\Base;
use ZanPHP\Contracts\ConnectionPool\Connection;

class Http extends Base implements Connection
{
    public function closeSocket()
    {

    }
}