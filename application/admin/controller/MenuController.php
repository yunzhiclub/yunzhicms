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
    // public function indexAction()
    // {
    //     $MenuTypeModels = MenuTypeModel::paginate();
    //     $this->assign('MenuTypeModels', $MenuTypeModels);
    //     return $this->fetch();
    // }

    public function editAction($id)
    {
        $MenuModel = MenuModel::get($id);
        $this->assign('MenuModel', $MenuModel);

        // 所有菜单类型
        $MenuTypeModels = MenuTypeModel::all();
        $this->assign('MenuTypeModels',$MenuTypeModels);

        // 所有的组件
        $Components = ComponentModel::all();
        $this->assign('Components', $Components);

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
        $MenuModel->setData('menu_type_name', $data['menu_type_name']);
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

        //若未返回数值，则置为空数组
        $data['access'] = isset($data['access'])?$data['access']:array();

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

        // 所有菜单类型
        $MenuTypeModels = MenuTypeModel::all();
        $this->assign('MenuTypeModels',$MenuTypeModels);

        // 所有的组件
        $Components = ComponentModel::all();
        $this->assign('Components', $Components);

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
        $MenuModel->setData('menu_type_name', $data['menu_type_name']);
        $MenuModel->setData('url', $data['url']);
        $MenuModel->setData('is_hidden', $data['is_hidden']);
        $MenuModel->setData('weight', $data['weight']);
        $MenuModel->setData('status', $data['status']);
        $MenuModel->setData('description', $data['description']);

        // 配置信息
        if (array_key_exists('config', $data))
        {
            $MenuModel->setData('config', json_encode($data['config']));
        }

        // 过滤器信息
        if (array_key_exists('filter', $data))
        {
            $filter = Common::makeFliterArrayFromPostArray($data['filter']);
            $MenuModel->setData('filter', json_encode($filter));
        }

        $id = $MenuModel->save();

        $data['access'] = isset($data['access'])?$data['access']:array();

        // 更新 菜单 用户组 权限
        AccessUserGroupMenuModel::updateByMenuIdAndUserGroups($id, $data['access']);

        $menuType = $MenuModel->getData('menu_type_name');
        return $this->success('操作成功', url('@admin/menuType/' . $menuType));

    }

    public function deleteAction($id)
    {
        $id = (int)$id;
        $MenuModel = MenuModel::get($id);

        //判断是否含有二级菜单
        $sonMenuModels = $MenuModel->sonMenuModels();
        $MenuModel->setData('is_delete', 1);
        $map = array('menu_id' => $id);
        if (false === $MenuModel->MenuBlock()->where($map)->delete()) {
            
            return $this->error('删除失败');
        }
        if (false === $MenuModel->MenuPlugin()->where($map)->delete()) {
            
            return $this->error('删除失败');
        }

        if (false === empty($sonMenuModels)) {
            
            return $this->error('不能删除因为含有子菜单');
        }

        if (false === $MenuModel->save()) {
            
            return $this->error('删除失败');
        }

        $menuType = $MenuModel->getData('menu_type_name');
        return $this->success('删除成功', url('@admin/menuType/' . $menuType));
    }
}