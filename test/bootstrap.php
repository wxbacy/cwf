<?php

// 引入全局引导文件
Yaf_Loader::import(dirname(dirname(__FILE__)) . '/bootstrap.php');

$application = new Yaf_Application(ROOT_PATH . '/conf/application.ini');
// 把配置保存起来
$arrConfig = Yaf_Application::app()->getConfig();
Yaf_Registry::set('config', $arrConfig);
