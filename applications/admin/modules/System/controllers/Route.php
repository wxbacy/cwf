<?php

/**
 * 路由控制器
 *
 * @author chenwei
 */
class RouteController extends BaseController
{
    // 路由列表
    public function indexAction()
    {
        $this->display('index');
    }
}
