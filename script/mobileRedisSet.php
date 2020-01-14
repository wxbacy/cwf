<?php

require_once "./bootstrap.php";

$application->execute(function (){
    $mobileCache = new \cache\MobileCache();
    $mobileCache->init();
});
