<?php

namespace dao;

use cache\MobileCache;
use db\UserDB;

/**
 * 用户相关数据层
 *
 * @author chenwei
 */
class UserDAO
{
    // 判断手机号是否存在
    public function existMobile($mobile)
    {
        if ((new MobileCache())->exist($mobile)) {
            return true;
        }
        return (new UserDB())->existMobile($mobile);
    }

    // 添加用户
    public function add($mobile, $password)
    {
        $userDB = new UserDB();
        $userid = $userDB->add($mobile, $password);

        $mobileCache = new MobileCache();
        $mobileCache->add($mobile);

        return $userid;
    }
}