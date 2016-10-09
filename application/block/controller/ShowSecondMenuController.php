<?php
namespace app\block\controller;
use app\Common;
use app\model\MenuModel;                        // 菜单模型
/**
 * ShowSecondMenu
 */
class ShowSecondMenuController extends BlockController
{
    protected $currentMenuModel = null;         //当前菜单
    public function index()
    {
    	// 取当前菜单信息
        $this->currentMenuModel = MenuModel::getCurrentMenuModel();

        $MenuModels = $this->currentMenuModel->getSecondMenuModle();
        $this->assign('MenuModels', $MenuModels);
        return $this->fetch();
    }
}