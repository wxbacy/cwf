<?php

namespace mq;

use code\ErrorCode;
use code\GeneralCode;
use Exception;
use AMQPConnection;
use Yaf_Registry;

/**
 * MQ操作基类，初始化MQ连接
 *
 * @author chenwei
 */
class BaseMQ
{
    protected $connection;

    /**
     * 默认连接名称
     *
     * @var string
     */
    const DEFAULT_LINKNAME = 'default';

    /**
     * 初始化AMQPConnection实例
     *
     * @throws Exception
     */
    public function __construct()
    {
        $linkName = $this->getLinkName();
        $mqConfig = $this->getConf($linkName);
        $connection = new AMQPConnection($mqConfig);
        if (! $connection->connect()) {
            throw new Exception('Cannot connect to the broker!', ErrorCode::getCode(GeneralCode::AMQP_CONNECT_FAIL));
        }
        $this->connection = $connection;
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
     * 获取MQ配置
     *
     * @return array
     * @throws Exception
     */
    private function getConf($linkName)
    {
        $mqConfig = Yaf_Registry::get('config')->mq->$linkName->toArray();
        if (empty($mqConfig['host'])) {
            throw new Exception('mq.' . $linkName . '.host不能为空');
        }
        if (empty($mqConfig['port'])) {
            throw new Exception('mq.' . $linkName . '.port不能为空');
        }
        if (empty($mqConfig['login'])) {
            throw new Exception('mq.' . $linkName . '.login不能为空');
        }
        if (empty($mqConfig['password'])) {
            throw new Exception('mq.' . $linkName . '.password不能为空');
        }
        if (empty($mqConfig['vhost'])) {
            throw new Exception('mq.' . $linkName . '.vhost不能为空');
        }
        return $mqConfig;
    }
}
