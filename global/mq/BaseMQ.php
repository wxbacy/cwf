<?php

namespace mq;

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
            throw new Exception('Cannot connect to the broker!');
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

    /**
     * 发送消息到exchange
     *
     * @param array string 消息数据
     * @throws \AMQPChannelException
     * @throws \AMQPConnectionException
     * @throws \AMQPExchangeException
     */
    public function publish($message)
    {
        $channel = new \AMQPChannel($this->connection);
        $exchange = new \AMQPExchange($channel);
        $exchange->setName(static::EXCHANGE_NAME);
        $exchange->publish(json_encode($message));
        $this->connection->disconnect();
    }

    /**
     * queue消费
     *
     * @param callable $callback 消费处理函数/方法
     * @throws \AMQPChannelException
     * @throws \AMQPConnectionException
     * @throws \AMQPEnvelopeException
     * @throws \AMQPQueueException
     */
    public function consume($queneName, callable $callback)
    {
        $channel = new \AMQPChannel($this->connection);
        $queue = new \AMQPQueue($channel);
        $queue->setName($queneName);
        echo '[*] Waiting for messages. To exit press CTRL+C' . PHP_EOL;
        while (true) {
            $queue->consume($callback, AMQP_AUTOACK);
        }
        $this->connection->disconnect();
    }
}
