<?php

namespace ZanPHP\ConnectionPool;

use InvalidArgumentException;
use ZanPHP\ConnectionPool\Exception\ConnectTimeoutException;
use ZanPHP\Coroutine\Contract\Async;
use ZanPHP\Coroutine\StaticEvent;
use ZanPHP\Coroutine\Task;
use ZanPHP\Timer\Timer;

class FutureConnection implements Async
{
    private $connKey = '';
    private $timeout = 0;
    private $taskCallback = null;
    private $pool;
    
    public function __construct($connKey, $timeout, $pool)
    {
        if(!is_int($timeout)){
            throw new InvalidArgumentException('Invalid timeout for Future[Connection]');
        }
        $this->connKey = $connKey;
        $this->timeout = $timeout;
        $this->pool = $pool;
        $pool->waitNum++;
        $this->init();
    }

    public function execute(callable $callback, $task)
    {
        $this->taskCallback = $callback;
    }

    private function init()
    {
        $evtName = $this->connKey . '_free';
        StaticEvent::once($evtName,[$this,'getConnection']);

        Timer::after($this->timeout, [$this, 'onConnectTimeout'], $this->getConnectTimeoutJobId());
    }

    public function getConnection()
    {
        Task::execute($this->doGeting());
    }

    public function doGeting()
    {
        try {
            if (!isset($this->taskCallback)) {
                return;
            }

            Timer::clearAfterJob($this->getConnectTimeoutJobId());

            if (isset($this->pool->waitNum) && $this->pool->waitNum > 0) {
                $this->pool->waitNum--;
            }

            $conn = (yield $this->pool->get());
            call_user_func($this->taskCallback, $conn);
            unset($this->taskCallback);

        } catch (\Throwable $t) {
            echo_exception($t);
        } catch (\Exception $ex) {
            echo_exception($ex);
        }
    }

    public function onConnectTimeout() {
        if (!isset($this->taskCallback)) {
            return;
        }

        $evtName = $this->connKey . '_free';
        StaticEvent::unbind($evtName, [$this, 'getConnection']);

        if (isset($this->pool->waitNum) && $this->pool->waitNum > 0) {
            $this->pool->waitNum--;
        }

        call_user_func($this->taskCallback, null, new ConnectTimeoutException("Future $this->connKey connection connected timeout"));
        unset($this->taskCallback);
    }

    private function getConnectTimeoutJobId()
    {
        return spl_object_hash($this) . '_future_connect_timeout';
    }
}