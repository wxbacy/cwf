<?php

require_once "./bootstrap.php";

use db\UserDB;

class Demo
{
    public function demo1()
    {
        $userDB = new UserDB();
        $user = $userDB->getUser(1);
        var_dump($user);
    }

    public function demo2($userId)
    {
        $userDB = new UserDB();
        $user = $userDB->getUser($userId);
        var_dump($user);
    }
}

// 要运行的函数或者方法, 方法可以通过array($obj, "method_name")来定义，函数直接用字符串，如$application->execute("method_name");
// $application->execute([new Demo(), 'demo1']);

// mixed Yaf_Application::execute(callback $function, mixed $parameter = NULL, $parameter $... = NULL);
// $parameter 零个或者多个要传递给函数的参数.
$application->execute([new Demo(), 'demo2'], 1);
