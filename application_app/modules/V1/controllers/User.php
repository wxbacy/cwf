<?php

class UserController extends BaseController
{
    public function getNameAction()
    {
        $this->success(['username' => '王小板爱吃鱼']);
    }
}
