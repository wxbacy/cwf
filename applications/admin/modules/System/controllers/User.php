<?php

use service\admin\AdminUserService;
use basic\Response;
use error\AdminError;

/**
 * 用户控制器
 *
 * @author chenwei
 */
class UserController extends BaseController
{
    // 用户列表
    public function indexAction()
    {
        $this->display('index');
    }

    // 用户列表数据
    public function dataListAction()
    {
        $offset = $this->getRequest()->getQuery('start');
        $limit = $this->getRequest()->getQuery('length');

        $adminUserService = new AdminUserService();
        $count = $adminUserService->getCount();
        $users = [];
        if ($count) {
            $users = $adminUserService->getUsers($offset, $limit);
            foreach ($users as &$user) {
                $user['created_at'] = date('Y-m-d H:i:s', $user['created_at']);
            }
            unset($user);
        }

        $this->datatableJson($count, $users);
    }

    // 编辑/新增表单
    public function formAction()
    {
        $adminUserID = $this->getRequest()->getQuery('admin_user_id');
        $adminUser = [];
        if ($adminUserID) {
            $adminUserService = new AdminUserService();
            $adminUser = $adminUserService->getByID($adminUserID);
        }

        $this->display('form', ['user' => $adminUser]);
    }

    // 保存用户
    public function saveAction()
    {
        $post = $this->getRequest()->getPost();

        $adminUser['account'] = $post['account'];
        $adminUser['password'] = $post['password'];

        $adminUserService = new AdminUserService();
        if ($post['admin_user_id']) {
            $adminUserService->save($post['admin_user_id'], $adminUser);
        } else {
            if ($adminUserService->getByAccount($adminUser['account'])) {
                (new Response())->error(AdminError::ADD_ACCOUNT_EXIST);
            }
            $adminUserService->add($adminUser);
        }

        (new Response())->success();
    }

    // 删除用户
    public function delAction()
    {
        $adminUserID = $this->getRequest()->getQuery('admin_user_id');

        $adminUserService = new AdminUserService();
        $adminUserService->del($adminUserID);

        (new Response())->success();
    }

    // 个人资料页
    public function profileAction()
    {
        $this->display('profile');
    }

    // 保存个人资料
    public function saveProfileAction()
    {
        $post = $this->getRequest()->getPost();

        $adminUserService = new AdminUserService();
        $sessionUser = $adminUserService->getSessionUser();

        $adminUser['password'] = $post['password'];
        $adminUserService->save($sessionUser['admin_user_id'], $adminUser);

        (new Response())->success();
    }
}