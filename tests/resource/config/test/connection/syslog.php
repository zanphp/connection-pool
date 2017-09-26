<?php
/**
 * Created by PhpStorm.
 * User: huye
 * Date: 2017/9/11
 * Time: 下午3:41
 */

return [
    'syslog_default' => [
        'engine'=> 'syslog',
        'host' => '10.9.65.239',
        'port' => 5140,
        'timeout' => 5000,
        'persistent' => true,
        'pool' => [
            'keeping-sleep-time' => 10000,
            'init-connection' => 1,
            'maximum-connection-count' => 3,
            'minimum-connection-count' => 1,
        ],
    ]
];