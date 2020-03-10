<?php

namespace service\admin;

use dao\AdminUserDAO;
use Yaf_Registry;
use Yaf_Session;

/**
 * 后台用户业务
 *
 * @author chenwei
 */
class AdminUserService
{
    public function checkLogin($account, $formPassword)
    {
        $adminUserDAO = new AdminUserDAO();
        $adminUser = $adminUserDAO->getByAccount($account);
        if (! $adminUser) {
            return false;
        }
        if ($this->encryptPassword($formPassword) !== $adminUser['password']) {
            return false;
        }
        return $adminUser;
    }

    public function getByAccount($account)
    {
        $adminUserDAO = new AdminUserDAO();
        return $adminUserDAO->getByAccount($account);
    }

    /**
     * 密码加密，使用客户端md5后拼接盐值，再进行一次md5
     *
     * @param $formPassword
     * @return string
     */
    private function encryptPassword($formPassword)
    {
        return md5($formPassword . Yaf_Registry::get('config')->password->salt);
    }

    public function login($adminUser)
    {
        Yaf_Session::getInstance()->set(Yaf_Registry::get('config')->admin->login_state_session_key, [
            'admin_user_id' => $adminUser['admin_user_id'],
            'account' => $adminUser['account'],
            'created_at' => $adminUser['created_at'],
        ]);
    }

    public function loginOut()
    {
        Yaf_Session::getInstance()->del(Yaf_Registry::get('config')->admin->login_state_session_key);
    }

    public function getSessionUser()
    {
        return Yaf_Session::getInstance()->get(Yaf_Registry::get('config')->admin->login_state_session_key);
    }

    public function getCount()
    {
        $adminUserDAO = new AdminUserDAO();
        return $adminUserDAO->getCount();
    }

    public function getUsers($offset, $limit)
    {
        $adminUserDAO = new AdminUserDAO();
        return $adminUserDAO->getUsers($offset, $limit);
    }

    public function save($adminUserID, $adminUser)
    {
        if (isset($adminUser['password'])) {
            $adminUser['password'] = $this->encryptPassword($adminUser['password']);
        }
        $adminUserDAO = new AdminUserDAO();
        return $adminUserDAO->save($adminUserID, $adminUser);
    }

    public function add($adminUser)
    {
        if (isset($adminUser['password'])) {
            $adminUser['password'] = $this->encryptPassword($adminUser['password']);
        }
        $adminUserDAO = new AdminUserDAO();
        return $adminUserDAO->add($adminUser);
    }

    public function getByID($adminUserID)
    {
        $adminUserDAO = new AdminUserDAO();
        return $adminUserDAO->getByID($adminUserID);
    }

    public function del($adminUserID)
    {
        $adminUserDAO = new AdminUserDAO();
        return $adminUserDAO->del($adminUserID);
    }
}