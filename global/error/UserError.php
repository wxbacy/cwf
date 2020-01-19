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
}
