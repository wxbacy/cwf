<?php

namespace db;

/**
 * 后台路由数据模型
 *
 * @author chenwei
 */
class AdminRouteDB extends BaseDB
{
    private $table = 'admin_route';

    public function getMenu()
    {
        return $this->select($this->table, [
            'admin_route_id',
            'name',
            'uri',
            'icon',
            'parent_route_id',
        ], [
            'is_menu' => 1,
            'ORDER' => ['admin_route_id' => 'DESC'],
        ]);
    }
}