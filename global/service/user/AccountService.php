<?php

namespace service\user;

use dao\UserDAO;
use mq\SignUpMQ;

/**
 * 用户账户业务
 *
 * @author chenwei
 */
class AccountService
{
    /**
     * 判断手机号是否已被注册
     *
     * @param $mobile 手机号
     * @return bool
     */
    public function existMobile($mobile)
    {
        return (new UserDAO())->existMobile($mobile);
    }

    /**
     * 注册用户
     *
     * @param $mobile
     * @param $password
     * @return int 用户id
     */
    public function add($mobile, $password)
    {
        $userDAO = new UserDAO();
        $userId = $userDAO->add($mobile, $password);

        // MQ用户注册事件
        $signUpMQ = new SignUpMQ();
        $message = $signUpMQ->build($userId);
        $signUpMQ->publish($message);

        return $userId;
    }

}