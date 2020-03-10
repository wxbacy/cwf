<?php

namespace dao;

use db\AdminRouteDB;

/**
 * 后台用户相关数据层
 *
 * @author chenwei
 */
class AdminRouteDAO
{
    public function getMenu()
    {
        $adminRouteDB = new AdminRouteDB();
        return $adminRouteDB->getMenu();
    }
}