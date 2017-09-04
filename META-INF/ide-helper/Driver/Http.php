<?php

namespace Zan\Framework\Network\Connection\Driver;

use ZanPHP\Contracts\ConnectionPool\Base;
use ZanPHP\Contracts\ConnectionPool\Connection;

class Http extends Base implements Connection
{
    public function closeSocket()
    {

    }
}