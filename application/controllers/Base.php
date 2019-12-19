<?php

use code\ErrorCode;
use code\GeneralCode;

/**
 * 控制器基类
 *
 * @author chenwei
 */
class BaseController extends Yaf_Controller_Abstract
{
    /**
     * response设置json响应体
     *
     * @param $responseContent array 响应体数据
     */
    protected function jsonResponse($responseContent)
    {
        header('Content-type: text/json');
        $responseContent = json_encode($responseContent);
        $response = new Yaf_Response_Http();
        $response->setBody($responseContent);
        $response->response();
    }

    /**
     * 响应数据格式化
     *
     * @param $errorConstant 错误常量
     * @param array $data data对象里的数据
     * @param string $msg 提示字符串
     * @return array 响应体数据
     */
    private function format($errorConstant, $data = [], $msg = '')
    {
        $responseContent['code'] = ErrorCode::getCode($errorConstant);

        if (! $msg) {
            $msg = ErrorCode::getMsg($errorConstant);
        }
        $responseContent['msg'] = $msg;
        if ($data) {
            $responseContent['data'] = $data;
        }
        return $responseContent;
    }

    /**
     * 成功响应
     *
     * @param array $data data对象里的数据
     * @param string $msg 提示字符串
     */
    protected function success($data = [], $msg = '')
    {
        $this->jsonResponse($this->format(GeneralCode::SUCCESS, $data, $msg));
    }

    /**
     * 错误响应
     *
     * @param $errorConstant 错误常量
     * @param array $data data对象里的数据
     * @param string $msg 提示字符串
     */
    protected function error($errorConstant, $msg = '', $data = [])
    {
        $this->jsonResponse($this->format($errorConstant, $data, $msg));
    }
}
