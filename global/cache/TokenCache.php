<?php

namespace cache;

use cache\BaseCache;

/**
 * 用户token缓存
 *
 * @author chenwei
 */
class TokenCache extends BaseCache
{
    private $key;

    /**
     * 连接名称，不定义默认使用配置文件里的default
     *
     * @var string
     */
    protected static $linkName = 'demo';

    /**
     * 在这里初始化key值
     *
     * @throws \Exception
     */
    public function __construct($client, $tokenType, $userId)
    {
        parent::__construct();
        $this->key = $client . '_' . $tokenType . '_' . $userId;
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
}
