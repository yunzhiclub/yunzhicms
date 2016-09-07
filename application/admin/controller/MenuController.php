<?php
namespace app\admin\controller;
use app\Common;                         // 通用函数库
use app\model\MenuModel;                // 菜单
use app\model\MenuTypeModel;            // 菜单类型
use app\model\UserGroupModel;           // 用户组
use app\model\AccessUserGroupMenuModel; // 用户组 菜单 权限
use app\model\ComponentModel;           // 组件

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

        var_dump($data);
        die();
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

        // 配置信息
        $MenuModel->setData('config', json_encode($data['config']));

        // 过滤器信息
        if (array_key_exists('filter', $data))
        {
            $filter = Common::makeFliterArrayFromPostArray($data['filter']);
            $MenuModel->setData('filter', json_encode($filter));
        }
       
        $MenuModel->save();

        // 更新 菜单 用户组 权限
        AccessUserGroupMenuModel::updateByMenuIdAndUserGroups($id, $data['access']);

        $menuType = $MenuModel->getData('menu_type_name');
        return $this->success('操作成功', url('@admin/menuType/' . $menuType));
    }

    public function createAction()
    {
        // 所有的菜单
        $MenuModels = MenuModel::all();
        $this->assign('MenuModels', $MenuModels);

        // 所有的组件
        $Components = ComponentModel::all();
        $this->assign('Components', $Components);

        // 传入v层一个空menu对象
        $MenuModel = new MenuModel;
        $this->assign('$MenuModel', $MenuModel);

        // 将用户组信息传入
        $userGroupModels = UserGroupModel::all();
        $this->assign('userGroupModels', $userGroupModels);

        return $this->fetch();
    }

    public function saveAction()
    {
        $data = input('param.');
       
        $MenuModel = new MenuModel;
        $MenuModel->setData('title', $data['title']);
        $MenuModel->setData('pid', $data['pid']);
        $MenuModel->setData('component_name', $data['component_name']);
        $MenuModel->setData('url', $data['url']);
        $MenuModel->setData('is_hidden', $data['is_hidden']);
        $MenuModel->setData('weight', $data['weight']);
        $MenuModel->setData('status', $data['status']);
        $MenuModel->setData('description', $data['description']);

        //配置信息
         $MenuModel->setData('config', json_encode($data['config']));

        // 过滤器信息
        if (array_key_exists('filter', $data))
        {
            $filter = Common::makeFliterArrayFromPostArray($data['filter']);
            $MenuModel->setData('filter', json_encode($filter));
        }

        $id = $MenuModel->save();

        // 更新 菜单 用户组 权限
        AccessUserGroupMenuModel::updateByMenuIdAndUserGroups($id, $data['access']);

        $menuType = $MenuModel->getData('menu_type_name');
        return $this->success('操作成功', url('@admin/menuType/' . $menuType));

    }
}