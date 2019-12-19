<?php

/**
 * 用户数据模型
 *
 * @author chenwei
 */
class UserModel extends BaseModel
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
