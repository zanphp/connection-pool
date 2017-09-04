<?php

namespace Zan\Framework\Network\Connection;

class MonitorConnectionNum {
    private $MonitorConnectionNum;

    public function __construct()
    {
        $this->MonitorConnectionNum = new \ZanPHP\ConnectionPool\MonitorConnectionNum();
    }

    public function controlLinkNum($poolMap)
    {
        $this->MonitorConnectionNum->controlLinkNum($poolMap);
    }

    public function reduceLinkNum()
    {
        $this->MonitorConnectionNum->reduceLinkNum();
    }
}