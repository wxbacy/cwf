<?php

/**
 * xxx队列消费
 *
 * @author chenwei
 */
require_once "../bootstrap.php";

use mq\MemberMQ;

$application->execute([new MemberMQ(), 'logConsume'], function ($envelope) {
    // 消费队列处理代码
    var_dump($envelope->getBody());
});
