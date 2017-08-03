<?php

return [
    \ZanPHP\ConnectionPool\Driver\Http::class => "Zan\\Framework\\Network\\Connection\\Driver\\Http",
    \ZanPHP\ConnectionPool\Driver\Mysql::class => "Zan\\Framework\\Network\\Connection\\Driver\\Mysql",
    \ZanPHP\ConnectionPool\Driver\Redis::class => "Zan\\Framework\\Network\\Connection\\Driver\\Redis",
    \ZanPHP\ConnectionPool\Driver\Syslog::class => "Zan\\Framework\\Network\\Connection\\Driver\\Syslog",
    \ZanPHP\ConnectionPool\Driver\Tcp::class => "Zan\\Framework\\Network\\Connection\\Driver\\Tcp",

    \ZanPHP\ConnectionPool\Exception\CanNotCreateConnectionException::class => "Zan\\Framework\\Network\\Connection\\Exception\\CanNotCreateConnectionException",
    \ZanPHP\ConnectionPool\Exception\ConnectionLostException::class => "Zan\\Framework\\Network\\Connection\\Exception\\ConnectionLostException",
    \ZanPHP\ConnectionPool\Exception\ConnectTimeoutException::class => "Zan\\Framework\\Network\\Connection\\Exception\\ConnectTimeoutException",
    \ZanPHP\ConnectionPool\Exception\GetConnectionTimeoutFromPool::class => "Zan\\Framework\\Network\\Connection\\Exception\\GetConnectionTimeoutFromPool",
    \ZanPHP\ConnectionPool\Exception\NoFreeConnectionException::class => "Zan\\Framework\\Network\\Connection\\Exception\\NoFreeConnectionException",

    \ZanPHP\ConnectionPool\Factory\Http::class => "Zan\\Framework\\Network\\Connection\\Factory\\Http",
    \ZanPHP\ConnectionPool\Factory\Mysql::class => "Zan\\Framework\\Network\\Connection\\Factory\\Mysql",
    \ZanPHP\ConnectionPool\Factory\Redis::class => "Zan\\Framework\\Network\\Connection\\Factory\\Redis",
    \ZanPHP\ConnectionPool\Factory\Syslog::class => "Zan\\Framework\\Network\\Connection\\Factory\\Syslog",
    \ZanPHP\ConnectionPool\Factory\Tcp::class => "Zan\\Framework\\Network\\Connection\\Factory\\Tcp",

    \ZanPHP\ConnectionPool\AsyncConnection::class => "Zan\\Framework\\Network\\Connection\\AsyncConnection",
    \ZanPHP\ConnectionPool\ConnectionEx::class => "Zan\\Framework\\Network\\Connection\\ConnectionEx",
    \ZanPHP\ConnectionPool\ConnectionInitiator::class => "Zan\\Framework\\Network\\Connection\\ConnectionInitiator",
    \ZanPHP\ConnectionPool\ConnectionManager::class => "Zan\\Framework\\Network\\Connection\\ConnectionManager",
    \ZanPHP\ConnectionPool\FutureConnection::class => "Zan\\Framework\\Network\\Connection\\FutureConnection",
    \ZanPHP\ConnectionPool\MonitorConnectionNum::class => "Zan\\Framework\\Network\\Connection\\MonitorConnectionNum",
    \ZanPHP\ConnectionPool\Pool::class => "Zan\\Framework\\Network\\Connection\\Pool",
    \ZanPHP\ConnectionPool\PoolEx::class => "Zan\\Framework\\Network\\Connection\\PoolEx",
    \ZanPHP\ConnectionPool\ReconnectionPloy::class => "Zan\\Framework\\Network\\Connection\\ReconnectionPloy",

    \ZanPHP\ConnectionPool\TCP\TcpClient::class => "Zan\\Framework\\Network\\Common\\TcpClient",
    \ZanPHP\ConnectionPool\TCP\TcpClientEx::class => "Zan\\Framework\\Network\\Common\\TcpClientEx",
    \ZanPHP\ConnectionPool\TCP\TcpSendErrorException::class => "Zan\\Framework\\Network\\Common\\Exception\\TcpSendErrorException",
    \ZanPHP\ConnectionPool\TCP\TcpSendTimeoutException::class => "Zan\\Framework\\Network\\Common\\Exception\\TcpSendTimeoutException",

];