<?php


namespace Zan\Framework\Network\Connection\Factory;

use ZanPHP\Contracts\ConnectionPool\ConnectionFactory;

class Http implements ConnectionFactory
{
    private $Http;

    public function __construct(array $config)
    {
        $this->Http = new \ZanPHP\ConnectionPool\Factory\Http($config);
    }
    
    public function create()
    {
        $this->Http->create();
    }

    public function close()
    {
        $this->Http->close();
    }

    public function heart()
    {
        $this->Http->heart();
    }
}