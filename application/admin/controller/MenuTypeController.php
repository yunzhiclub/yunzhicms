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

    public function createAction()
    {
       return $this->fetch(); 
    }

    public function saveAction()
    {
        $data = input('param.');
        $MenuTypeModel = new MenuTypeModel;
        $MenuTypeModel->setData('title', $data['title']);
        $MenuTypeModel->setData('name', $data['name']);
        $MenuTypeModel->setData('description', $data['description']);

        $MenuTypeModel->save();

        return $this->success('保存成功', url('@admin/menutype'));

    }
}