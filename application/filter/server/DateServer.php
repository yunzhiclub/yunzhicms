<?php
namespace app\filter\server;
/**
 * 日期过滤器
 */
class DateServer
{
    static public function format($timestamp, $param = array()) {
        $dataFormat = 'Y-m-d';
        if (is_array($param) && array_key_exists('dateFormat', $param))
        {
            $dataFormat = $param['dateFormat']['value'];
        }
        return date($dataFormat, $timestamp);
    }
}