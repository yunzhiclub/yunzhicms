<?php
namespace app\filter\server;
/**
 * 日期过滤器
 */
class DateServer
{
    static public function formart($timestamp, $param = 'Y-m-d') {
        return date($param, $timestamp);
    }
}