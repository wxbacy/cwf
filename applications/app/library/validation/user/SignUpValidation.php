<?php

namespace library\validation\user;

use Inhere\Validate\FieldValidation;
use Yaf_Config_Ini;

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
            ['mobile', 'required|regexp', (new Yaf_Config_Ini(CONF_PATH . '/regex.ini'))->get('mobile')],
            ['password', 'required|regexp', (new Yaf_Config_Ini(CONF_PATH . '/regex.ini'))->get('password')],
        ];
    }
}
