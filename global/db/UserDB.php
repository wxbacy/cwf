<?php

namespace db;

/**
 * 用户数据模型
 *
 * @author chenwei
 */
class UserDB extends BaseDB
{
    private $table = 'user';

    // 获取用户信息
    public function getUser($userId)
    {
        return $this->get($this->table, [
            'user_id',
            'mobile'
        ], [
            'user_id' => $userId
        ]);
    }

    // 判断手机号是否存在
    public function existMobile($mobile)
    {
        return $this->has($this->table, ['mobile' => $mobile]);
    }

    // 添加用户
    public function add($mobile, $password)
    {
        $this->insert($this->table, [
            'mobile' => $mobile,
            'password' => $password,
            'created_at' => time()
        ]);
        return $this->id();
    }

    // 获取用户密码
    public function getPassword($mobile)
    {
        return $this->get($this->table, 'password', ['mobile' => $mobile]);
    }

    // 获取用户id
    public function getUserId($mobile)
    {
        return $this->get($this->table, 'user_id', ['mobile' => $mobile]);
    }
}
