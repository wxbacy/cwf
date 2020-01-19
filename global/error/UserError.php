<?php

namespace error;

/**
 * 用户模块错误码，11开头
 * 00: 用户账户
 *
 * @author chenwei
 */
class UserError
{
    /** 用户账号1100xx **/
    const ACCOUNT_MOBILE_EXIST = ['code' => '110000', 'msg' => '该手机号已被注册'];
    const ACCOUNT_MOBILE_NOT_EXIST = ['code' => '110001', 'msg' => '该手机号还未注册'];
    const ACCOUNT_PASSWORD_ERROR = ['code' => '110002', 'msg' => '你的密码不正确'];
}
