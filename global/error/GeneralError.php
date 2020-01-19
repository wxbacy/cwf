<?php

namespace error;

/**
 * 全局错误码，x10开头
 *
 * @author chenwei
 */
class GeneralError
{
    /** 成功 **/
    const SUCCESS = ['code' => '0', 'msg' => '请求成功'];

    /** 请求参数错误 1000xx **/
    const PARAMS_ERROR = ['code' => '100000', 'msg' => '请求参数错误'];  // 参数错误

    /** token相关 1001xx **/
    const TOKEN_INVAILD = ['code' => '100100', 'msg' => '没有有效的token'];  // 没有有效的token
    const TOKEN_REFRESH_EXPIRE_FAIL = ['code' => '100102'];  // token刷新有效期失败

    /** MQ 1002xx **/
    const AMQP_CONNECT_FAIL = ['code' => '101100'];  // amqp连接失败
}
