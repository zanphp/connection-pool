<?php

namespace ZanPHP\ConnectionPool\Factory;

use ZanPHP\Contracts\ConnectionPool\ConnectionFactory;

class Http implements ConnectionFactory
{
    /**
     * @var array
     */
    private $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }
    
    public function create()
    {
        
    }

    public function close()
    {

    }

    public function heart()
    {

    }

    public function getFactoryType()
    {
        return "Http";
    }
}