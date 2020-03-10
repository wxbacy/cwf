<?php

namespace dao;

use db\AdminUserDB;

/**
 * 后台用户相关数据层
 *
 * @author chenwei
 */
class AdminUserDAO
{
    public function getByAccount($account)
    {
        return (new AdminUserDB())->getByAccount($account);
    }

    public function getCount()
    {
        $adminUserDB = new AdminUserDB();
        return $adminUserDB->getCount();
    }

    public function getUsers($offset, $limit)
    {
        $adminUserDB = new AdminUserDB();
        return $adminUserDB->getUsers($offset, $limit);
    }

    public function add($adminUser)
    {
        $adminUserDB = new AdminUserDB();
        return $adminUserDB->add($adminUser);
    }

    public function save($adminUserID, $adminUser)
    {
        $adminUserDB = new AdminUserDB();
        return $adminUserDB->save($adminUserID, $adminUser);
    }

    public function getByID($adminUserID)
    {
        $adminUserDB = new AdminUserDB();
        return $adminUserDB->getByID($adminUserID);
    }

    public function del($adminUserID)
    {
        $adminUserDB = new AdminUserDB();
        return $adminUserDB->del($adminUserID);
    }
}