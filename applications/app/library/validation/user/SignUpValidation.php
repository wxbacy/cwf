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
            ['mobile', 'required|regexp', Yaf_Registry::get('regex')->mobile],
            ['password', 'required|regexp', Yaf_Registry::get('regex')->password],
        ];
    }
}
