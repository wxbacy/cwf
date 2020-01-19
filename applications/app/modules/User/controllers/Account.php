<?php

use service\user\AccountService;
use basic\Response;
use error\UserError;
use error\GeneralError;
use library\validation\user\SignUpValidation;
use Inhere\Validate\Validation;

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

        // 注册
        $userId = $accountService->signUp($safeData['mobile'], $safeData['password']);

        // 登录
        $token = $accountService->signIn($userId);

        (new Response())->success(['token' => $token]);
    }

    // 登录
    public function signInAction()
    {
        $v = Validation::check($this->getRequest()->getPost(), [
            ['mobile, password', 'required'],
            ['mobile', 'regexp', (new Yaf_Config_Ini(CONF_PATH . '/regex.ini'))->get('mobile')],
            ['password', 'regexp', (new Yaf_Config_Ini(CONF_PATH . '/regex.ini'))->get('password')],
        ]);
        if ($v->isFail()) {
            (new Response())->error(GeneralError::PARAMS_ERROR, $v->firstError());
            return;
        }
        $safeData = $v->getSafeData();

        // 验证手机号是否已经被注册
        $accountService = new AccountService();
        if (! $accountService->existMobile($safeData['mobile'])) {
            (new Response())->error(UserError::ACCOUNT_MOBILE_NOT_EXIST);
            return;
        }

        // 验证手机号和密码是否匹配
        if (! $accountService->validatePassword($safeData['mobile'], $safeData['password'])) {
            (new Response())->error(UserError::ACCOUNT_PASSWORD_ERROR);
            return;
        }

        // 获取用户id
        $userId = $accountService->getUserId($safeData['mobile']);

        // 登录
        $token = $accountService->signIn($userId);

        (new Response())->success(['token' => $token]);
    }

    // 退出登录
    public function signOutAction()
    {
        $currentUserId = Yaf_Registry::get('current_user_id');

        $accountService = new AccountService();
        $accountService->signOut($currentUserId);

        (new Response())->success();
    }
}