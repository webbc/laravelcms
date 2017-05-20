<?php
/**
 * 工具函数
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/21 0021
 * Time: 21:17
 */
function p($var = '') {
    if (is_object($var) || is_array($var)) {
        echo "<pre>";
        print_r($var);
        echo "</pre>";
    } else {
        echo $var;
    }
    die;
}

function success($message, $url = '', $time = 3) {
    return view('common.jump')->with([
        'message' => $message,
        'url' => $url,
        'jumpTime' => 3
    ]);
}

function error($message, $url = '', $time = 3) {
    return success($message, $url, $time);
}

