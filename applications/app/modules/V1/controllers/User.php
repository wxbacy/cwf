<?php

use basic\Response;

class UserController extends Yaf_Controller_Abstract
{
    public function getNameAction()
    {
        (new Response())->success(['username' => '王小板爱吃鱼']);
    }
}
