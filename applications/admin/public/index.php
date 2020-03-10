<?php

define('APPLICATION_PATH', realpath(dirname(__FILE__). '/../'));
define('PUBLIC_PATH', realpath(dirname(__FILE__)));

// 引入全局引导文件
Yaf_Loader::import(APPLICATION_PATH . '/../../bootstrap.php');

$app = new Yaf_Application(ROOT_PATH . "/conf/application.ini");
$app->bootstrap()->run();
