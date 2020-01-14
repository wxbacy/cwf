<?php

namespace cache;

use Exception;
use Redis;
use Yaf_Registry;

/**
 * 缓存基类，缓存实例，单例
 *
 * @author chenwei
 */
class BaseCache
{
    /**
     * redis实例
     *
     * @var Redis
     */
    protected $redis;

    /**
     * 默认连接名称
     *
     * @var string
     */
    const DEFAULT_LINKNAME = 'default';

    /**
     * redis实例化
     *
     * @throws Exception
     */
    public function __construct()
    {
        static $cacheConnecter;
        if ($cacheConnecter) {
            $this->redis = $cacheConnecter;
            return;
        }
        $linkName = $this->getLinkName();
        $redisConfig = $this->getConf($linkName);
        $this->redis = $cacheConnecter = $this->connect($redisConfig);
    }

    /**
     * 获取配置
     *
     * @param $linkName 连接名称
     * @return array
     * @throws Exception
     */
    private function getConf($linkName)
    {
        $redisConfig = Yaf_Registry::get('config')->redis->$linkName->toArray();
        if (empty($redisConfig['host'])) {
            throw new Exception('配置项redis.' . $linkName . '.host不能为空');
        }
        if (empty($redisConfig['port'])) {
            throw new Exception('配置项redis.' . $linkName . '.port不能为空');
        }
        return $redisConfig;
    }

    /**
     * 获取连接名称，子类有静态变量指定则用子类指定的，否则用默认连接
     *
     * @return string
     */
    private function getLinkName()
    {
        if (empty(static::$linkName)) {
            return self::DEFAULT_LINKNAME;
        }
        return static::$linkName;
    }

    /**
     * 连接redis，返回\Redis实例
     *
     * @param $redisConfig 配置
     * @return Redis
     * @throws Exception
     */
    private function connect($redisConfig)
    {
        $redis = new Redis();
        if (! $redis->pconnect($redisConfig['host'], $redisConfig['port'], 5)) {
            throw new Exception('redis connect fail');
        }
        if (! empty($redisConfig['password'])) {
            if (! $redis->auth($redisConfig['password'])) {
                throw new Exception('redis connection is auth fail');
            }
        }
        return $redis;
    }
}
