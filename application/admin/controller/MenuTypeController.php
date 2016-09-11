<?php
namespace app\admin\controller;
use app\model\MenuModel;                // 菜单
use app\model\MenuTypeModel;            // 菜单类型

class MenutypeController extends AdminController
{
    public function indexAction()
    {
        $pageSize = 5;
        $MenuTypeModel = new MenuTypeModel;
        $MenuTypeModels = $MenuTypeModel->where('is_delete', '=', 0)->paginate($pageSize);
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

    public function deleteAction($id)
    {
        $name = $id;
        if (null === $name) {
            
            return $this->error('未找到相关记录');
        }

        //判断里面是不是有菜单
        $MenuModel = new MenuModel;
        $MenuModels = $MenuModel->getListsByMenuTypeNamePid($name, 0, 0);
        
        if (false === empty($MenuModels)) {
            
            return $this->error('含有下一级菜单不能删除');
        }

        $map = array('name' => $name);
        $MenuTypeModel = MenuTypeModel::get($map);
        $MenuTypeModel->setData('is_delete', 1);

        if (false === $MenuTypeModel->save()) {
            
            return $this->error('删除失败');
        }

        return $this->success('删除成功', url('@admin/menutype'));
    }

    public function createAction()
    {
        return $this->fetch();
    }

    public function saveAction()
    {
        $data = input('post.');
        $MenuTypeModel = new MenuTypeModel;
        $MenuTypeModel->setData('title', $data['title']);
        $MenuTypeModel->setData('name', $data['name']);
        $MenuTypeModel->setData('description', $data['description']);

        $MenuTypeModel->save();

        return $this->success('保存成功', url('@admin/menutype'));
    }
}