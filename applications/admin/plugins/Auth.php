<?php

use basic\Response;
use service\admin\AdminUserService;
use service\admin\AdminRouteService;

/**
 * 身份验证插件
 *
 * @author chenwei
 */
class AuthPlugin extends Yaf_Plugin_Abstract
{
    // 以下路由无需token
    const UNWANTED_AUTH_ROUTES = [
        'Auth.Login.index',
        'Auth.Verify.get',
        'Auth.Login.in',
        'Auth.Login.out',
    ];


    // 当前路由模块
    private $module;
    // 当前路由控制器
    private $controller;
    // 当前路由方法
    private $action;

    /**
     * 路由结束之后触发，token校验
     *
     * @param Yaf_Request_Abstract $request
     * @param Yaf_Response_Abstract $response
     */
    public function routerShutdown(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
    {
        // 根据模块名传递接口统计信息
        $this->module = $request->getModuleName();
        $this->controller = $request->getControllerName();
        $this->action = $request->getActionName();

        $currentRoute = $this->module . '.' . $this->controller . '.' . $this->action;

        if (in_array($currentRoute, self::UNWANTED_AUTH_ROUTES)) {
            return;
        }

        // session验证
        // token使用，token使用header自定义参数
        $adminUserService = new AdminUserService();
        if (! $adminUserService->getSessionUser()) {
            (new Response())->notFound();
            exit();
        }

        // 菜单
        $uri = lcfirst($this->module) . '/' . lcfirst($this->controller) . '/' . $this->action;
        $adminRouteService = new AdminRouteService();
        $menu = $adminRouteService->getMenuTree($uri);
        Yaf_Registry::set('menu', $menu);
    }
}
