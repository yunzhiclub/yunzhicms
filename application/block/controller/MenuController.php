<?php
namespace app\block\controller;
use app\model\MenuModel;                    // 菜单

/**
 * 菜单
 */
class MenuController extends BlockController
{
    protected $token;
	public function fetchHtml()
	{
        // 取当前菜单信息
        $this->currentMenuModel = MenuModel::getCurrentMenuModel();

        $menuTypeName = $this->config['menu_type_name']['value'];
        $pid = 0;

        $this->assign('token', $this->BlockModel->makeToken('Menu', 'edit'));

        $menuModels = MenuModel::getAvailableSonMenuModelsByPidMenuTypeName($pid, $menuTypeName);
        $this->assign('menuModels', $menuModels);
		return $this->fetch('block@Menu/fetchHtml');
	}
}