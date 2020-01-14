<?php

namespace db;

use db\BaseDB;

/**
 * 会员数据模型
 *
 * @author chenwei
 */
class MemberDB extends BaseDB
{
    private $table = 'member';

    /**
     * 判断会员是否存在
     *
     * @param $memberId 会员id
     * @return bool
     */
    public function hasMember($memberId)
    {
        return $this->has($this->table, [
            'member_id' => $memberId
        ]);
    }
}
