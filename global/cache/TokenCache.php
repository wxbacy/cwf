<?php

namespace cache;

use cache\BaseCache;
use mysql_xdevapi\Exception;

/**
 * 用户token缓存
 *
 * @author chenwei
 */
class TokenCache extends BaseCache
{
    private $key;

    /**
     * 在这里初始化key值
     *
     * @throws \Exception
     */
    public function __construct($client, $userId)
    {
        parent::__construct();
        $this->key = $client . '_' . $userId;
    }

    /**
     * 设置token
     *
     * @param $userId 用户id
     * @param $token token值
     * @return bool|int
     */
    public function set($ttl, $token)
    {
        return $this->redis->setex($this->key, $ttl, $token);
    }

    /**
     * 判断缓存里用户token是否过期
     *
     * @param $token
     * @return bool
     */
    public function isLive($token)
    {
        return $this->redis->get($this->key) == $token;
    }

    /**
     * 删除对应token缓存
     *
     * @return int
     */
    public function del()
    {
        return $this->redis->del($this->key);
    }

    /**
     * 设置token有效期
     *
     * @param $ttl
     * @return bool
     */
    public function expire($ttl)
    {
        if ($this->redis->expire($this->key, $ttl)) {
            throw new Exception('刷新token缓存有效期失败');
        }
    }
}
