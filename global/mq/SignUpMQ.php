<?php

namespace mq;

use mq\BaseMQ;

/**
 * 注册事件exchange的相关数据的定义
 *
 * @author chenwei
 */
class SignUpMQ extends BaseMQ
{
    const EXCHANGE_NAME = 'User.SignUp';

    /**
     * 生成投递到exchange的message
     *
     * @param $userid
     * @return array message
     */
    public function build($userid)
    {
        return ['application' => Yaf_Registry::get('application'), 'userid' => $userid];
    }
}