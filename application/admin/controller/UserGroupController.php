<?php
namespace app\admin\controller;

use app\model\UserGroupModel;

use app\model\AccessUserGroupBlockModel;   //AccessUserGroupBlockModel

use app\model\AccessUserGroupMenuModel;    //AccessUserGroupMenuModel

class UserGroupController extends AdminController
{
    /**
     * 显示用户组信息
     * @author liuyanzhao
     * @return template
     */
    public function indexAction()
    {
        $UserGroupModel = new UserGroupModel;

        //获取config.php中的分页配置信息
        $pageSize = config('paginate.var_page');
        $map      = array('is_delete' => 0);
    	$UserGroupModels = $UserGroupModel->where($map)->paginate($pageSize);
    	$this->assign('UserGroupModels', $UserGroupModels);
        // return $this->fetch();
        return $this->fetch('UserGroup/index');
    }

    public function editAction($name)
    {
        //获取对象
        $UserGroupModel = UserGroupModel::get($name);

        //获取用户组是否实是系统自己设置的
        if (1 === $UserGroupModel->is_system) {
            return $this->error('此用户组是系统默认设置不能编辑');
        }
        
    	$UserGroupModel = UserGroupModel::get($name);
    	$this->assign('UserGroupModel', $UserGroupModel);
    	return $this->fetch('UserGroup/edit');
    }

    public function updateAction()
    {
        $name = input('param.name');
    	$data = input('param.');

    	$UserGroupModel = UserGroupModel::get($name);
    	$UserGroupModel->setData('title', $data['title']);
    	$UserGroupModel->setData('description', $data['description']);

        $datas = array(
            'title'       => $data['title'],
            'description' => $data['description'],
            'name'        => $name,
         );

        //验证并保存
        if (false === $UserGroupModel->validate()->isUpdate()->save($datas)) {
            return $this->error($UserGroupModel->getError());
        }

    	return $this->success('操作成功', url('index'));
    }

    public function createAction()
    {
        return $this->fetch('UserGroup/create');
    }

    public function saveAction()
    {
        $data = input('param.');

        //保存数据
        $UserGroupModel = new UserGroupModel;
        $UserGroupModel->setData('title', $data['title']);
        $UserGroupModel->setData('name', $data['name']);
        $UserGroupModel->setData('description', $data['description']);

        //验证并保存
        if (false === $UserGroupModel->validate(true)->save($data)) {
            return $this->error($UserGroupModel->getError());
        }

        return $this->success('操作成功', url('index')); 
    }

    /**
     * 删除用户组
     * @param  [string] $id
     * @author  gaoliming 
     * @return template
     */
    public function deleteAction($name)
    {
        //获取对象
        $UserGroupModel = UserGroupModel::get($name);

        //获取用户组是否实是系统自己设置的
        if (1 === $UserGroupModel->is_system) {
            return $this->error('此用户组是系统默认设置不能删除');
        }

        //判断是否还有用户
        $UserModels = $UserGroupModel->getAllUserModel($name);
        if (!empty($UserModels)) {
            return $this->error('含有子用户,不能删除');
        }

        //删除中间表信息
        $map = array('user_group_name' => $name);
        $AccessUserGroupBlockModel = new AccessUserGroupBlockModel;
        $AccessUserGroupMenuModel = new AccessUserGroupMenuModel;
        if (false === $AccessUserGroupBlockModel->where($map)->delete()) {
            return $this->error('删除失败');
        }
        if (false === $AccessUserGroupMenuModel->where($map)->delete()) {
            return $this->error('删除失败');
        }

        //将用户组删除
        $UserGroupModel->setData('is_delete', 1)->save();

        //返回首页
        return $this->success('删除成功', url('index')); 
    }

}