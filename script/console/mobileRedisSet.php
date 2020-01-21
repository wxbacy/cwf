<?php

require_once "../bootstrap.php";

use cache\MobileCache;

$application->execute(function (){
    $mobileCache = new MobileCache();
    $mobileCache->init();
});
