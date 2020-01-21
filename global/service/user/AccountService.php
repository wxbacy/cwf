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
        $userDAO = new UserDAO();
        return $userDAO->existMobile($mobile);
    }

    /**
     * 注册用户
     *
     * @param $mobile
     * @param $password
     * @return int 用户id
     */
    public function signUp($mobile, $formPassword)
    {
        $userDAO = new UserDAO();
        $dbPassword = $this->encryptPassword($formPassword);
        $userId = $userDAO->add($mobile, $dbPassword);

        // MQ用户注册事件
        $signUpMQ = new SignUpMQ();
        $message = $signUpMQ->build($userId);
        $signUpMQ->publish($message);

        return $userId;
    }

    /**
     * 密码加密，使用客户端md5后拼接盐值，再进行一次md5
     *
     * @param $formPassword
     * @return string
     */
    private function encryptPassword($formPassword)
    {
        return md5($formPassword . 'WZLY');
    }

    /**
     * 登录
     *
     * @param $userId
     * @return bool|string
     */
    public function signIn($userId)
    {
        // 生成token
        $authService = new AuthService();
        $authService->setAppClient();
        return $authService->createToken($userId);
    }

    /**
     * 注销登录
     *
     * @param $userId
     * @throws \Exception
     */
    public function signOut($userId)
    {
        $authService = new AuthService();
        $authService->setAppClient();
        $authService->invalidToken($userId);
    }

    /**
     * 验证手机号的密码
     *
     * @param $mobile
     * @param $password
     * @return bool
     */
    public function validatePassword($mobile, $formPassword)
    {
        $userDAO = new UserDAO();
        $dbPassword = $userDAO->getPassword($mobile);

        return $this->encryptPassword($formPassword) === $dbPassword;
    }

    /**
     * 获取用户id
     *
     * @param $mobile
     * @return 用户id
     */
    public function getUserId($mobile)
    {
        $userDAO = new UserDAO();
        return $userDAO->getUserId($mobile);
    }
}