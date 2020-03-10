<?php

use basic\verify\Verify;
use error\AdminError;
use basic\Response;
use service\admin\AdminUserService;

/**
 * 登录相关
 *
 * @author chenwei
 */
class LoginController extends Yaf_Controller_Abstract
{
    // 登录页面
    public function indexAction()
    {
        $formSign = $this->getRequest()->getQuery('sign', '');
        $realSign = Yaf_Registry::get('config')->admin->login_page_sign;
        if ($formSign !== $realSign) {
            (new Response())->notFound();
            exit();
        }
        $this->display('index');
    }

    // 登录
    public function inAction()
    {
        $post = $this->getRequest()->getPost();
        $account = $post['account'];
        $password = $post['password'];
        $verifyCode = $post['verify'];

        $verify = new Verify();
        if (! $verify->check($verifyCode)) {
            (new Response())->error(AdminError::VERIFY_CODE_ERROR);
            return;
        }
        // 验证账号密码
        $adminUserService = new AdminUserService();
        $adminUser = $adminUserService->checkLogin($account, $password);
        if (! $adminUser) {
            (new Response())->error(AdminError::LOGIN_FAIL);
            return;
        }

        // 登录
        $adminUserService->login($adminUser);

        (new Response())->success();
    }

    // 退出登录
    public function outAction()
    {
        $adminUserService = new AdminUserService();
        $adminUserService->loginOut();

        $sign = Yaf_Registry::get('config')->admin->login_page_sign;
        $this->redirect('/auth/login/index?sign=' . $sign);
    }
}