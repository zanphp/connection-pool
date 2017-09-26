<?php
/**
 * Created by PhpStorm.
 * User: huye
 * Date: 2017/9/18
 * Time: 上午11:43
 */
return [
    'default_write' => [
        'engine'=> 'mysqli',
        'host' => '127.0.0.1',
        'user' => 'root',
        'password' => '123',
        'database' => 'test',
        'port' => '3306',
        'pool'  => [
            'maximum-connection-count' => 10,
            'minimum-connection-count' => 1,
            'heartbeat-time' => 35000,
            'init-connection'=> 1,
        ],
    ],

];
