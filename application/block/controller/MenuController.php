<?php
namespace app\block\controller;
use app\block\model\MenuModel;            // 菜单

/**
 * 菜单
 */
class MenuController extends BlockController
{
	public function fetchHtml()
	{
        
        $menuTypeName = $this->config['menu_type_name']['value'];
        $pid = 0;

        $menuModels = MenuModel::getAvailableSonMenuModelsByPidMenuTypeName($pid, $menuTypeName);
        $this->assign('menuModels', $menuModels);
		return $this->fetch('block@Menu/fetchHtml');
	}
}