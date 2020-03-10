<?php

namespace service\admin;

use dao\AdminRouteDAO;
use basic\utils\ArrayUtils;

/**
 * 后台菜单路由业务
 *
 * @author chenwei
 */
class AdminRouteService
{
    public function getMenuTree($uri)
    {
        $adminRouteDAO = new AdminRouteDAO();
        $menus = $adminRouteDAO->getMenu();

        $sourceRouteIds = [];
        foreach ($menus as $menu) {
            if ($menu['uri'] == $uri || in_array($menu['admin_route_id'], $sourceRouteIds)) {
                $sourceRouteIds[] = $menu['admin_route_id'];
                $sourceRouteIds[] = $menu['parent_route_id'];
            }
        }
        foreach ($menus as &$menu) {
            if (in_array($menu['admin_route_id'], $sourceRouteIds)) {
                $menu['active'] = true;
            } else {
                $menu['active'] = false;
            }
        }
        unset($menu);

        krsort($menus);

        return ArrayUtils::tree($menus, 0, 'admin_route_id', 'parent_route_id');
    }
}