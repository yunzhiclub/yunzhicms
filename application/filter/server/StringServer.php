<?php
namespace app\filter\server;
/**
 * 字符串过滤器
 */
class StringServer
{
    /**
     * 字符串截取函数
     * @param  string $string 输入字符串
     * @param  array  $config 配置信息
     * $length 截取的长度
     * $etc 截取后缀
     * @return string         过滤后的字符串
     */
    static public function substr($string, $config = array()) {
        $length = '10';
        $etc = '...';
        if (array_key_exists('length', $config))
        {
            $length = (int)$config['length'];
        }

        if (array_key_exists('etc', $config))
        {
            $etc = (string)$config['etc'];
        }

        $result = '';
        $string = html_entity_decode ( trim ( strip_tags ( $string ) ), ENT_QUOTES, 'UTF-8' );
        $strlen = strlen ( $string );
        for($i = 0; (($i < $strlen) && ($length > 0)); $i ++) {
            if ($number = strpos ( str_pad ( decbin ( ord ( substr ( $string, $i, 1 ) ) ), 8, '0', STR_PAD_LEFT ), '0' )) {
                if ($length < 1.0) {
                    break;
                }
                $result .= substr ( $string, $i, $number );
                $length -= 1.0;
                $i += $number - 1;
            } else {
                $result .= substr ( $string, $i, 1 );
                $length -= 0.5;
            }
        }
        $result = htmlspecialchars ( $result, ENT_QUOTES, 'UTF-8' );
        if ($i < $strlen) {
            $result .= $etc;
        }
        return $result;
    }
}