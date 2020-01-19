<?php

namespace library\validation\user;

use Inhere\Validate\FieldValidation;

/**
 * 注册表单验证
 *
 * @author chenwei
 */
class SignUpValidation extends FieldValidation
{
    // 验证规则
    public function rules() :array
    {
        return [
            ['mobile', 'required|regexp', '/^1\d{10}$/'],
            ['password', 'required|regexp', '/^\w{6,16}$/'],
        ];
    }
}
