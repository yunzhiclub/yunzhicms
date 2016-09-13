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
    /**
     * 启用当前模板
     * @param  string $name 数据表中name字段
     * @author huangshuaibin
     * @return bool
     */
    static public function setDefaultTheme($name)
    {
        //取出 is_current值为 1 对象数组
    	$map = array('is_current' => 1);        
        $CurrentModels = ThemeModel::where($map)->select(); 

        //将 is_current 的字段赋值 0 保存
        $CurrentModels[0]['is_current'] = 0;       
        $CurrentModel1 = $CurrentModels[0];        
        $CurrentModel1->save();
        
        //取出当前主题对象  将is_current字段赋值为 1
    	$ThemeModel = ThemeModel::get($name);
    	$ThemeModel->is_current = 1;
    	$ThemeModel->save();
    }
}