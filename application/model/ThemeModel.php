<?php
namespace app\model;
/**
 * 主题
 */
class ThemeModel extends ModelModel
{
    static public function getCurrentThemeModel()
    {
        $map = ['is_current' => '1'];
        return self::get($map);
    }
}