<?php

namespace basic;

use error\Error;
use error\GeneralError;
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

    /**
     * 响应过滤处理，msg优先级 传参>error定义 业务类型错误码error必须定义msg
     *
     * @param $errorConstant
     * @param $data
     * @param $msg
     * @return $this
     */
    private function filter($errorConstant, $data, $msg)
    {
        $this->code = Error::getCode($errorConstant);
        $this->msg = $msg ?: Error::getMsg($errorConstant);
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
    public function success(array $data = [], $msg = '')
    {
        $this->filter(GeneralError::SUCCESS, $data, $msg)->format()->json();
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

    public function nativeJson($resp)
    {
        $this->body = json_encode($resp);
        $this->json();
    }

    /**
     * 404 NOT FOUND
     *
     * @return void
     */
    public function notFound()
    {
        header("HTTP/1.1 404 Not Found");
        echo "<!DOCTYPE html>
              <html>
                <head>
                  <meta charset='UTF-8'>
                </head>
                <body>
                  <h2>We are sorry, the page you requested cannot be found.</h2>
                  <p>The URL may be misspelled or the page you're looking for is no longer available.</p>
                </body>
              </html>";
    }
}