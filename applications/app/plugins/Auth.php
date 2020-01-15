<?php

use code\ErrorCode;
use code\GeneralCode;
use service\AuthService;

/**
 * 身份验证插件
 *
 * @author chenwei
 */
class AuthPlugin extends Yaf_Plugin_Abstract
{
    const UNWANTED_AUTH_ROUTES = [
        'Index.Member.demo1',
        'Index.Member.demo2',
        'Index.Member.demo3',
        //'Index.Member.demo4',
        'Index.Member.demo5',
        'V1.User.getname',
    ];

    private $module;
    private $controller;
    private $action;

    /**
     * 路由结束之后触发
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

        // token验证
        // token使用，token使用header自定义参数
        if (empty($_SERVER['HTTP_TOKEN'])) {
            throw new Exception(ErrorCode::getMsg(GeneralCode::TOKEN_INVAILD), ErrorCode::getCode(GeneralCode::TOKEN_INVAILD));
        }
        $authService = new AuthService(strtolower($this->module));
        $authService->setTokenType('access_token');
        $userId = $authService->parseToken($_SERVER['HTTP_TOKEN']);
        if (! $authService->validateToken($userId, $_SERVER['HTTP_TOKEN'])) {
            throw new Exception(ErrorCode::getMsg(GeneralCode::TOKEN_INVAILD), ErrorCode::getCode(GeneralCode::TOKEN_INVAILD));
        }
    }
}
