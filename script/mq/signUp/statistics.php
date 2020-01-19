<?php

/**
 * 注册事件队列消费：数据统计
 *
 * @author chenwei
 */
require_once "../../bootstrap.php";

use mq\SignUpMQ;

$application->execute([new SignUpMQ(), 'consume'], 'SignUp.Statistics', function ($envelope) {
    // 消费队列处理代码
    var_dump($envelope->getBody());
    // TODO::数据统计
});
