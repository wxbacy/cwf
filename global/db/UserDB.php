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
}
