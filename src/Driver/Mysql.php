<?php

namespace ZanPHP\ConnectionPool\Driver;

use ZanPHP\Contracts\ConnectionPool\Base;
use ZanPHP\Contracts\ConnectionPool\Connection;
use ZanPHP\Database\Mysql\Mysql as Engine;
use ZanPHP\ConnectionPool\ReconnectionPloy;
use ZanPHP\Coroutine\Task;
use ZanPHP\Support\Time;
use ZanPHP\Timer\Timer;

class Mysql extends Base implements Connection
{
    protected $isAsync = true;
    private $classHash = null;

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
        $this->classHash = spl_object_hash($this);
    }

    public function onConnect(\swoole_mysql $cli, $result) {
        Timer::clearAfterJob($this->getConnectTimeoutJobId());
        if (property_exists($cli, "connect_errno")) {
            $so_errno = $cli->connect_errno;
        } else {
            $so_errno = 0;
        }
        // (非mariodb驱动)swoole bug: $result 恒等于true
        if ($result && $so_errno === 0) {
            $this->release();
            ReconnectionPloy::getInstance()->connectSuccess(spl_object_hash($this));
            $this->heartbeat();
            sys_echo("mysql client connect to server " . $this->getConnString());
        } else {
            if ($cli->connect_errno) {
                sys_error("mysql connect fail [errno={$cli->connect_errno}, errmsg={$cli->connect_error}] " . $this->getConnString());
                $this->close();
            }
        }
    }

    public function onClose(\swoole_mysql $cli){
        Timer::clearAfterJob($this->getConnectTimeoutJobId());
        $this->close();
        sys_echo("mysql client close {$cli->error}({$cli->errno}) " . $this->getConnString());
    }

    public function onError(\swoole_mysql $cli){
        Timer::clearAfterJob($this->getConnectTimeoutJobId());
        $this->close();
        sys_error("mysql client error {$cli->error}({$cli->errno}) " . $this->getConnString());
    }

    public function close()
    {
        Timer::clearAfterJob($this->getHeartBeatingJobId());
        parent::close();
    }

    public function heartbeat()
    {
        $this->heartbeatLater();
    }

    public function heartbeatLater()
    {
        Timer::after($this->config['pool']['heartbeat-time'], [$this,'heartbeating'], $this->getHeartBeatingJobId());
    }

    public function heartbeating()
    {
        $time = Time::current(true) - $this->lastUsedTime;
        $hearBeatTime = $this->config['pool']['heartbeat-time'] / 1000;
        if ($this->lastUsedTime != 0 && $time <  $hearBeatTime) {
            Timer::after(($hearBeatTime-$time) * 1000, [$this,'heartbeating'], $this->getHeartBeatingJobId());
            return;
        }

        $coroutine = $this->ping();
        Task::execute($coroutine);
    }

    public function ping()
    {
        $connRemoved = $this->pool->getFreeConnection()->remove($this);
        if ($connRemoved === false) {
            $this->heartbeatLater();
            return;
        }

        $this->pool->getActiveConnection()->push($this);

        $this->setUnReleased();
        $engine = new Engine($this);

        try{
            yield $engine->query('select 1');
        } catch (\Throwable $t) {
            echo_exception($t);
            $this->closeSocket();
            return;
        } catch (\Exception $e){
            echo_exception($e);
            $this->closeSocket();
            return;
        }

        $this->release();
        $this->heartbeatLater();
    }

    private function getHeartBeatingJobId()
    {
        return $this->classHash . '_heart_beating_job_id';
    }
}