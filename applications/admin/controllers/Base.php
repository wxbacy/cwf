<?php

use service\admin\AdminUserService;
use basic\Response;

/**
 * 控制器父类
 *
 * @author chenwei
 */
class BaseController extends Yaf_Controller_Abstract
{
    protected function init()
    {
        $adminUserService = new AdminUserService();
        $sessionUser = $adminUserService->getSessionUser();

        $menu = Yaf_Registry::get('menu');

        $this->getView()->assign('user', $sessionUser);
        $this->getView()->assign('menu', $menu);
    }

    protected function datatableJson($recordsFiltered, $data)
    {
        $draw = $this->getRequest()->getQuery('draw');

        (new Response())->nativeJson([
            'draw' => $draw,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ]);
    }
}