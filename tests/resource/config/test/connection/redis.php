<?php
/**
 * Created by PhpStorm.
 * User: huye
 * Date: 2017/9/18
 * Time: 上午11:43
 */
return [
    'default_write' => [
        'engine'=> 'redis',
        'host' => '127.0.0.1',
        'port' => 6379,
        'pool'  => [
            'maximum-connection-count' => 10,
            'minimum-connection-count' => 1,
            'keeping-sleep-time' => 10,
            'init-connection'=> 1,
        ],
    ]
];
