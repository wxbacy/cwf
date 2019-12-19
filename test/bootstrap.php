<?php

define('APPLICATION_PATH', dirname(dirname(__FILE__)));

// 引入composer的autoload.php
Yaf_Loader::import(APPLICATION_PATH . '/vendor/autoload.php');

$application = new Yaf_Application( APPLICATION_PATH . '/conf/application.ini');
$application->bootstrap();
