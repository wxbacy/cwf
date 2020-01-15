<?php

namespace basic;

use code\ErrorCode;
use code\GeneralCode;
use Yaf_Response_Http;
use stdClass;

/**
 * http响应
 *
 * @author chenwei
 */
class Response
{
    /**
     * @var array
     *
     * 响应数据
     */
    private $body;

    private $code;
    private $msg;
    private $data;

    /**
     * response设置json响应体
     *
     * @return void
     */
    private function json()
    {
        header('Content-type: text/json');
        $response = new Yaf_Response_Http();
        $response->setBody($this->body);
        $response->response();
    }

    /**
     * 响应数据格式化
     *
     * @return $this
     */
    private function format()
    {
        $body['code'] = $this->code;
        $body['msg'] = $this->msg;
        $body['data'] = $this->data ?: new stdClass();
        $this->body = json_encode($body);

        return $this;
    }

    private function filter($errorConstant, $data, $msg)
    {
        $this->code = ErrorCode::getCode($errorConstant);
        $this->msg = $msg ?: ErrorCode::getMsg($errorConstant);
        $this->data = $data;

        return $this;
    }

    /**
     * 成功响应
     *
     * @param array $data data对象里的数据
     * @param string $msg 提示字符串
     * @return void
     */
    public function success(array $data = [], string $msg = '')
    {
        $this->filter(GeneralCode::SUCCESS, $data, $msg)->format()->json();
    }

    /**
     * 错误响应
     *
     * @param $errorConstant 错误常量
     * @param array $data data对象里的数据
     * @param string $msg 提示字符串
     * @return void
     */
    public function error($errorConstant, $msg = '', $data = [])
    {
        $this->filter($errorConstant, $data, $msg)->format()->json();
    }

    /**
     * 异常响应
     *
     * @param $code
     * @param $msg
     * @return void
     */
    public function exception($code, $msg)
    {
        $this->code = $code;
        $this->msg = $msg;
        $this->format()->json();
    }
}