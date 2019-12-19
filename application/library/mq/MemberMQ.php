<?php

namespace mq;

use mq\BaseMQ;

/**
 * member exchange的相关操作，相关生产者与消费者
 *
 * @author chenwei
 */
class MemberMQ extends BaseMQ
{
    const EXCHANGE_NAME = 'member';

    /**
     * 发送消息到member exchange
     *
     * @param $message string 消息数据
     * @throws \AMQPChannelException
     * @throws \AMQPConnectionException
     * @throws \AMQPExchangeException
     */
    public function publish($message)
    {
        $channel = new \AMQPChannel($this->connection);
        $exchange = new \AMQPExchange($channel);
        $exchange->setName(self::EXCHANGE_NAME);
        $exchange->publish($message);
        $this->connection->disconnect();
    }

    /**
     * member.log queue消费
     *
     * @param callable $callback 消费处理函数/方法
     * @throws \AMQPChannelException
     * @throws \AMQPConnectionException
     * @throws \AMQPEnvelopeException
     * @throws \AMQPQueueException
     */
    public function logConsume(callable $callback)
    {
        $channel = new \AMQPChannel($this->connection);
        $queue = new \AMQPQueue($channel);
        $queue->setName('member.log');
        echo '[*] Waiting for messages. To exit press CTRL+C' . PHP_EOL;
        while (true) {
            $queue->consume($callback, AMQP_AUTOACK);
        }
        $this->connection->disconnect();
    }
}
