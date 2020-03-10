<?php

namespace error;

/**
 * 后台模块错误码，12开头
 * 00: 登录相关
 * 01：后台用户管理
 *
 * @author chenwei
 */
class AdminError
{
    /** 登录相关1200xx **/
    const VERIFY_CODE_ERROR = ['code' => '120000', 'msg' => '验证码不正确'];
    const LOGIN_FAIL = ['code' => '120001', 'msg' => '用户名或者密码错误'];

    /** 后台用户管理相关1201xx **/
    const ADD_ACCOUNT_EXIST = ['code' => '120100', 'msg' => '账号已存在'];
}