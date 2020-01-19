<?php

namespace db;

use db\BaseDB;

/**
 * 用户数据模型
 *
 * @author chenwei
 */
class UserDB extends BaseDB
{
    private $table = 'user';

    /**
     * 获取用户信息
     *
     * @param $userId 用户id
     * @return bool|mixed
     */
    public function getUser($userId)
    {
        return $this->get($this->table, [
            'user_id',
            'username'
        ], [
            'user_id' => $userId
        ]);
    }

    public function existMobile($mobile)
    {
        return $this->has($this->table, ['mobile' => $mobile]);
    }

    public function add($mobile, $password)
    {
        $this->insert($this->table, [
            'mobile' => $mobile,
            'password' => $password,
            'created_at' => time()
        ]);
        return $this->id();
    }
}
