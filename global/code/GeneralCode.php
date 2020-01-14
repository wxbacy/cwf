<?php

namespace code;

/**
 * 全局错误码，10开头
 *
 * @author chenwei
 */
class GeneralCode
{
    const SUCCESS = ['code' => 0, 'msg' => '请求成功'];
    // 参数错误，详见msg
    const PARAMS_ERROR = ['code' => 100000, 'msg' => '参数错误'];
    // 无效的token
    const TOKEN_INVAILD = ['code' => 101000, 'msg' => '无效的token'];
    // amqp连接失败
    const AMQP_CONNECT_FAIL = ['code' => 101100, 'msg' => 'amqp连接失败'];
}
