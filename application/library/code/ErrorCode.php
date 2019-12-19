<?php

namespace code;

/**
 * 错误码相关操作
 *
 * @author chenwei
 */
class ErrorCode
{
    /**
     * 获取错误码
     *
     * @param $error 错误常量
     * @return int
     */
    public static function getCode($error)
    {
        return $error['code'];
    }

    /**
     * 获取错误提示字符串
     *
     * @param $error 错误常量
     * @return string
     */
    public static function getMsg($error)
    {
        return $error['msg'];
    }
}
