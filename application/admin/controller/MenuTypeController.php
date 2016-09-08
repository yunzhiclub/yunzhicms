<?php
namespace app\admin\controller;
use app\model\MenuModel;                // 菜单
use app\model\MenuTypeModel;            // 菜单类型

class MenutypeController extends AdminController
{
    public function indexAction()
    {
        $MenuTypeModels = MenuTypeModel::paginate();
        $this->assign('MenuTypeModels', $MenuTypeModels);
        return $this->fetch();
    }

    public function readAction($id)
    {
        $name = $id;
        $MenuModelType = MenuTypeModel::get($name);
        $this->assign('MenuModelType', $MenuModelType);

        $MenuModel = new MenuModel;
        $MenuModels = $MenuModel->getListsByMenuTypeNamePid($name, 0, 0);
        $this->assign('MenuModels', $MenuModels);
        return $this->fetch();
    }
}