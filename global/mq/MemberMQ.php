<?php

namespace mq;

use mq\BaseMQ;

/**
 * member exchange的相关数据的定义
 *
 * @author chenwei
 */
class MemberMQ extends BaseMQ
{
    const EXCHANGE_NAME = 'member';

    /**
     * 生成投递到exchange的message
     *
     * @param $userid
     * @param $username
     * @return array message
     */
    public function build($userid, $username)
    {
        return ['userid' => $userid, 'username' => $username];
    }
}
