<?php

namespace db;

/**
 * 后台用户数据模型
 *
 * @author chenwei
 */
class AdminUserDB extends BaseDB
{
    private $table = 'admin_user';

    // 获取用户信息
    public function getByAccount($account)
    {
        return $this->get($this->table, [
            'admin_user_id',
            'account',
            'password',
            'created_at',
        ], [
            'account' => $account,
            'deleted_at' => 0
        ]);
    }

    // 获取数量
    public function getCount()
    {
        return $this->count($this->table, [
            'deleted_at' => 0
        ]);
    }

    public function getUsers($offset, $limit)
    {
        return $this->select($this->table, [
            'admin_user_id',
            'account',
            'created_at',
        ], [
            'deleted_at' => 0,
            'ORDER' => ['admin_user_id' => 'DESC'],
            'LIMIT' => [$offset, $limit],
        ]);
    }

    public function add($adminUser)
    {
        $adminUser['created_at'] = time();
        return $this->insert($this->table, $adminUser);
    }

    public function save($adminUserID, $adminUser)
    {
        $adminUser['updated_at'] = time();
        return $this->update($this->table, $adminUser, [
            'admin_user_id' => $adminUserID
        ]);
    }

    public function getByID($adminUserID)
    {
        return $this->get($this->table, [
            'admin_user_id',
            'account',
            'password',
        ], [
            'admin_user_id' => $adminUserID,
            'deleted_at' => 0
        ]);
    }

    public function del($adminUserID)
    {
        return $this->update($this->table, [
            'deleted_at' => time(),
        ], [
            'admin_user_id' => $adminUserID,
        ]);
    }
}