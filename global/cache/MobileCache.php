<?php

namespace cache;

use cache\BaseCache;

/**
 * 用户token缓存
 *
 * @author chenwei
 */
class MobileCache extends BaseCache
{
    private $key = 'mobile_set';

    public function init()
    {
        $mobile = 13000000000;
        echo 'start task' . PHP_EOL;
        for ($i=0; $i<7000000; $i++) {
            $mobile++;
            $this->redis->sAdd($this->key, $mobile);
            if ($i % 10000 === 0) {
                echo '已完成' . $i . '个' . PHP_EOL;
            }
        }
        echo 'all complete' . PHP_EOL;
    }
}