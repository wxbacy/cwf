<?php

define('ROOT_PATH', realpath(dirname(__FILE__)));
// 引入composer的autoload.php
Yaf_Loader::import(ROOT_PATH . '/vendor/autoload.php');
// 引入助手函数文件
Yaf_Loader::import(ROOT_PATH . '/global/helpers.php');