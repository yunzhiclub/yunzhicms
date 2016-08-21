<?php
namespace app\admin\controller;
use app\model\MenuModel;                // 菜单
use app\model\MenuTypeModel;            // 菜单类型

class MenuController extends AdminController
{
    public function indexAction()
    {
        $MenuTypeModels = MenuTypeModel::paginate();
        $this->assign('MenuTypeModels', $MenuTypeModels);
        return $this->fetch();
    }

    public function editAction($id)
    {
        $MenuModel = MenuModel::get($id);
        $this->assign('MenuModel', $MenuModel);
        return $this->fetch();
    }
}