<?php
namespace app\admin\controller;
use app\Common;                         // 通用函数库
use app\model\MenuModel;                // 菜单
use app\model\MenuTypeModel;            // 菜单类型
use app\model\UserGroupModel;           // 用户组

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

        // 将用户组信息传入
        $userGroupModels = UserGroupModel::all();
        $this->assign('userGroupModels', $userGroupModels);

        return $this->fetch();
    }

    public function updateAction($id)
    {
        $data = input('param.');
        $MenuModel = MenuModel::get($id);
        $MenuModel->setData('title', $data['title']);
        $MenuModel->setData('pid', $data['pid']);
        $MenuModel->setData('component_name', $data['component_name']);
        $MenuModel->setData('url', $data['url']);
        $MenuModel->setData('is_hidden', $data['is_hidden']);
        $MenuModel->setData('weight', $data['weight']);
        $MenuModel->setData('description', $data['description']);
        $MenuModel->setData('status', $data['status']);
        $MenuModel->setData('description', $data['description']);
        $MenuModel->setData('config', json_encode($data['config']));

        if (array_key_exists('filter', $data))
        {
            $filter = Common::makeFliterArrayFromPostArray($data['filter']);
            $MenuModel->setData('filter', json_encode($filter));
        }
       
        $MenuModel->save();

        $menuType = $MenuModel->getData('menu_type_name');
        return $this->success('操作成功', url('@admin/menuType/' . $menuType));
    }
}