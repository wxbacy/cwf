<?php

namespace cache;

/**
* 使用redis锁限制并发访问类
*
* @author chenwei
*/
class LockCache extends BaseCache
{
    private $key;

    /**
     * 在这里初始化key值
     *
     * @throws \Exception
     */
    public function __construct($key)
    {
        parent::__construct();
        $this->key = $key;
    }

    /**
     * 获取锁
     *
     * @param  Int $expire 锁过期时间
     * @return Boolean
     */
    public function lock($expire = 5)
    {
        $isLock = $this->redis->setnx($this->key, time() + $expire);
        // 不能获取锁
        if (! $isLock) {
            // 判断锁是否过期
            $lockTime = $this->redis->get($this->key);
            // 锁已过期，删除锁，重新获取
            if (time() > $lockTime) {
                $this->unlock($this->key);
                $isLock = $this->redis->setnx($this->key, time() + $expire);
            }
        }
        return $isLock ? true : false;
    }

    /**
     * 释放锁
     *
     * @return Boolean
     */
    public function unlock()
    {
        return $this->redis->del($this->key);
    }
}
