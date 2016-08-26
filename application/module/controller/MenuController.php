<?php
namespace app\module\controller;
use app\model\MenuModel;            // 菜单
/**
 * 菜单
 */
class MenuController extends ModuleController
{
	public function fetchHtml()
	{
        $map = ['menu_type_name' => $this->config['menu_type_name']['value']];
        $map['pid'] = 0;
        $map['is_hidden'] = 0;
        $menuModels = MenuModel::where($map)->select();
        $this->assign('menuModels', $menuModels);
		return $this->fetch('module@Menu/fetchHtml');
	}
}