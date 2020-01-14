<?php

use Inhere\Validate\FieldValidation;
use library\validation\MemberValidation;
use Curl\Curl;
use mq\MemberMQ;

class MemberController extends BaseController
{
    public function demo1Action()
    {
        $this->success(['info' => 'it works']);
    }

    public function demo2Action()
    {
        // 简单验证
        $v = FieldValidation::check($this->getRequest()->getPost(), [
            // add rule
            ['title', 'required|min:40'],
            ['freeTime', 'required|number'],
        ]);

        if ($v->isFail()) {
            var_dump($v->getErrors());
            var_dump($v->firstError());
            return;
        }

        // $postData = $v->all(); // 原始数据
        // $safeData = $v->getSafeData(); // 验证通过的安全数据

        // DO YOUR JOB
    }

    public function demo3Action()
    {
        // 复杂表单验证
        $v = MemberValidation::check($this->getRequest()->getPost());

        if ($v->isFail()) {
            var_dump($v->getErrors());
            var_dump($v->firstError());
            return;
        }

        // $postData = $v->all(); // 原始数据
        // $safeData = $v->getSafeData(); // 验证通过的安全数据

        // DO YOUR JOB
    }

    public function demo4Action()
    {
        $curl = new Curl();
        // get
        $curl->get('https://v4malu2x.api.7799520.com/');
        // post
        /*
        $curl = new Curl();
        $curl->post('https://www.example.com/login/', array(
            'username' => 'myusername',
            'password' => 'mypassword',
        ));
        */

        if ($curl->error) {
            echo 'Error: ' . $curl->errorCode . ': ' . $curl->errorMessage . "\n";
        } else {
            echo 'Response:' . "\n";
            var_dump($curl->response);
        }
    }

    public function demo5Action()
    {
        $memberMQ = new MemberMQ();
        $message = $memberMQ->build('560652', '王小板爱吃鱼');
        $memberMQ->publish($message);
    }
}
