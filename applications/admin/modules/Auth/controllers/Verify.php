<?php

use basic\verify\Verify;

/**
 * 验证码相关
 *
 * @author chenwei
 */
class VerifyController extends Yaf_Controller_Abstract
{
    /**
     * 获取验证码
     *
     * @return void
     */
    public function getAction()
    {
        $verify = new Verify(['length' => 4, 'codeSet' => '1023456789']);
        $verify->entry();
    }
}