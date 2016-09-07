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
     * @param  string $id 数据表中name字段
     * @return bool
     */
    public function enable($id)
    {
    	$ThemeModel = new ThemeModel;
    	$ThemeModels = $ThemeModel::All();
    	foreach ($ThemeModels as $ThemeModel => $value) {
    		$value->is_current = 0;
    		$value->save();
    	}

    	$name = $id;
    	$ThemeModel = ThemeModel::get($name);
    	
    	$ThemeModel->is_current = 1;
    	$ThemeModel->save();
    }
}