<?php
namespace app\component\controller;
/**
 * 位置position
 */
class PositionController extends ComponentController
{
    /**
     * 初始化，供Cx中position标签调用
     * @param  string $name 位置名字
     * @return string       html文本
     * @author panjie
     */ 
    static public function init($name)
    {
        // 找出所有在当前position下的block
        // 依次进行渲染，拼接
        // 返回拼接后的字符串
    }
}