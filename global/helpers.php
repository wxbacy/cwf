<?php

/**
 * 助手函数
 *
 * @author chenwei
 */

if (! function_exists('dump')) {
    /**
     * 浏览器友好的变量输出
     */
    function dump($var, $echo=true, $label=null, $strict=true)
    {
        $label = ($label === null) ? '' : rtrim($label) . ' ';
        if (! $strict) {
            if (ini_get('html_errors')) {
                $output = print_r($var, true);
                $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
            } else {
                $output = $label . print_r($var, true);
            }
        } else {
            ob_start();
            var_dump($var);
            $output = ob_get_clean();
            if (! extension_loaded('xdebug')) {
                $output = preg_replace('/\]\=\>\n(\s+)/m', '] => ', $output);
                $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
            }
        }
        if ($echo) {
            echo($output);
            return null;
        }else
            return $output;
    }
}

if (! function_exists('dd')) {
    /**
     * 打印调试
     */
    function dd()
    {
        array_map(function($x) { dump($x); }, func_get_args());
        exit;
    }
}

if (! function_exists('isProduct')) {
    /**
     * 是否生产环境
     */
    function isProduct()
    {
        if (YAF_ENVIRON === 'product') {
            return true;
        }
        return false;
    }
}

if (! function_exists('mtime')) {

    /**
     * 获取当前时间，精确到微秒
     *
     * @return float
     */
    function mtime()
    {
        $mtime = explode(" ", microtime());
        return $mtime[1] + $mtime[0];
    }
}