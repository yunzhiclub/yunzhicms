<?php
namespace app\module\controller;
use app\module\model\MenuModel;            // 菜单

/**
 * 菜单
 */
class MenuController extends ModuleController
{
	public function fetchHtml()
	{
        
        $menuTypeName = $this->config['menu_type_name']['value'];
        $pid = 0;

        $menuModels = MenuModel::getAvailableSonMenuModelsByPidMenuTypeName($pid, $menuTypeName);
        $this->assign('menuModels', $menuModels);
		return $this->fetch('module@Menu/fetchHtml');
	}
}