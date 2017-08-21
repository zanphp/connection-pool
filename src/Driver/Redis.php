<?php

namespace ZanPHP\ConnectionPool\Driver;

use ZanPHP\ConnectionPool\ReconnectionPloy;
use ZanPHP\Contracts\ConnectionPool\Base;
use ZanPHP\Contracts\ConnectionPool\Connection;
use ZanPHP\Timer\Timer;

class Redis extends Base implements Connection
{
    protected $isAsync = true;

    public function closeSocket()
    {
        try {
            $this->getSocket()->close();
        } catch (\Throwable $t) {
            echo_exception($t);
        } catch (\Exception $e) {
            echo_exception($e);
        }
    }

    public function init() {
        //set callback
        $this->getSocket()->on('close', [$this, 'onClose']);
    }

    public function onClose($redis){
        Timer::clearAfterJob($this->getConnectTimeoutJobId());
        $this->close();
        sys_echo("redis client close " . $this->getConnString());
    }

    public function onConnect($redis, $res) {
        // 避免swoolebug
        /** @noinspection PhpUndefinedFieldInspection */
        if ($this->getSocket()->isClosed) {
            if ($res) {
                $this->getSocket()->close();
            }
            return;
        }


        Timer::clearAfterJob($this->getConnectTimeoutJobId());

        if (false === $res) {
            sys_error("redis client connect error" . $this->getConnString());
            $this->close();
            return;
        }


        if (isset($this->config["password"])) {
            $pwd = $this->config["password"];
            $this->auth($redis, $pwd);
        } else if (isset($this->config["selectDB"])) {
            $index = $this->config["selectDB"];
            $this->selectDB($redis, $index);
        } else {
            $this->connected();
        }
    }

    private function auth(\swoole_redis $redis, $pwd, $timeout = 1000)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $timerId = Timer::after($timeout, function() {
            sys_error("redis auth timeout" . $this->getConnString());
            $this->close();
        });

        /** @noinspection PhpUndefinedMethodInspection */
        $r = $redis->auth($pwd, function($redis, $result) use($timerId) {
            Timer::clearAfterJob($timerId);
            if ($result) {
                if (isset($this->config["selectDB"])) {
                    $index = $this->config["selectDB"];
                    $this->selectDB($redis, $index);
                } else {
                    $this->connected();
                }
            } else {
                sys_error("redis auth fail" . $this->getConnString());
                $this->close();
            }
        });

        if (!$r) {
            sys_error("redis auth call fail" . $this->getConnString());
            $this->close();
        }
    }

    private function selectDB(\swoole_redis $redis, $index, $timeout = 1000)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $timerId = Timer::after($timeout, function() {
            sys_error("redis select timeout" . $this->getConnString());
            $this->close();
        });

        /** @noinspection PhpUndefinedMethodInspection */
        $r = $redis->select($index, function($redis, $result) use($timerId) {
            Timer::clearAfterJob($timerId);
            if ($result) {
                $this->connected();
            } else {
                sys_error("redis select fail" . $this->getConnString());
                $this->close();
            }
        });

        if (!$r) {
            sys_error("redis select call fail" . $this->getConnString());
            $this->close();
        }
    }

    private function connected()
    {
        //put conn to active_pool
        $this->release();
        ReconnectionPloy::getInstance()->connectSuccess(spl_object_hash($this));
        sys_echo("redis client connect to server " . $this->getConnString());
    }
}