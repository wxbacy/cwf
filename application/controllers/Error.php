<?php

/**
 * 错误控制器, 在发生未捕获的异常时刻被调用
 *
 * @author chenwei
 */
class ErrorController extends BaseController
{
    // 从2.1开始, errorAction支持直接通过参数获取异常
    public function errorAction($exception)
    {
        $this->jsonResponse(['code' => $exception->getCode(), 'msg' => $exception->getMessage()]);
    }
}
