<?php
namespace app\filter\server;
/**
 * 日期过滤器
 */
class DateServer
{
    static public function formart($timestamp, $param = array()) {
        $dataFormat = 'Y-m-d';
        if (is_array($param) && array_key_exists('dataFormat', $param))
        {
            $dataFormat = $param['dataFormat'];
        }
        return date($dataFormat, $timestamp);
    }
}