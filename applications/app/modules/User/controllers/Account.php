<?php

use service\user\AccountService;
use service\user\AuthService;
use basic\Response;
use error\UserError;
use error\GeneralError;
use library\validation\user\SignUpValidation;

/**
 * 用户账号
 *
 * @author chenwei
 */
class AccountController extends Yaf_Controller_Abstract
{
    // 注册
    public function signUpAction()
    {
        $v = SignUpValidation::check($this->getRequest()->getPost());
        if ($v->isFail()) {
            (new Response())->error(GeneralError::PARAMS_ERROR, $v->firstError());
            return;
        }
        $safeData = $v->getSafeData();

        // 验证手机号是否已经被注册
        $accountService = new AccountService();
        if ($accountService->existMobile($safeData['mobile'])) {
            (new Response())->error(UserError::ACCOUNT_MOBILE_EXIST);
            return;
        }

        // 添加用户
        $userid = $accountService->add($safeData['mobile'], $safeData['password']);

        // 生成token
        $authService = new AuthService();
        $authService->setAppClient();
        $token = $authService->createToken($userid);

        (new Response())->success(['token' => $token]);
    }

    // 登录
    public function signInAction()
    {

    }

    // 退出登录
    public function signOutAction()
    {
        $currentUserId = Yaf_Registry::get('current_user_id');

        $authService = new AuthService();
        $authService->setAppClient();
        $authService->invalidToken($currentUserId);

        (new Response())->success();
    }
}