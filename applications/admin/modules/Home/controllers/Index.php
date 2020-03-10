<?php

/**
 * 首页控制器
 *
 * @author chenwei
 */
class IndexController extends BaseController
{
    /**
     * 首页
     *
     * @return void
     */
    public function indexAction()
    {
        $this->display('index');
    }
}
