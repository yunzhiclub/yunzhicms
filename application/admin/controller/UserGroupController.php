<?php
namespace app\admin\controller;

use app\model\UserGroupModel;

class UserGroupController extends AdminController
{
    public function indexAction()
    {
        $UserGroupModel = new UserGroupModel;
    	$UserGroupModels = $UserGroupModel->where('is_deleted', '=', 0)->select();
    	$this->assign('UserGroupModels', $UserGroupModels);
        return $this->fetch();
    }

    public function editAction($id)
    {
    	$UserGroupModel = UserGroupModel::get($id);
    	$this->assign('UserGroupModel', $UserGroupModel);
    	return $this->fetch();
    }

    public function updateAction($id)
    {
    	$data = input('param.');

    	$UserGroupModel = UserGroupModel::get($id);
    	$UserGroupModel->setData('title', $data['title']);
    	$UserGroupModel->setData('name', $data['name']);
    	$UserGroupModel->setData('description', $data['description']);

    	$UserGroupModel->save();
    	return $this->success('操作成功', url('@admin/usergroup/'));
    }

    public function createAction()
    {
        return $this->fetch();
    }

    public function saveAction()
    {
        $data = input('param.');

        $UserGroupModel = new UserGroupModel;
        $UserGroupModel->setData('title', $data['title']);
        $UserGroupModel->setData('name', $data['name']);
        $UserGroupModel->setData('description', $data['description']);

        $UserGroupModel->save();
        return $this->success('操作成功', url('@admin/usergroup/')); 
    }

    public function deleteAction($id)
    {
        $UserGroupModel = UserGroupModel::get($id);
        //判断是否还有用户
        $UserModels = $UserGroupModel->getAllUserMedel($id);
        if (!empty($UserModels)) {
            
            return $this->error('不能删除含有子人员');
        }

        $UserGroupModel->setData('is_deleted', 1);
        //删除中间表信息
        $map = array('user_group_name' => $id);
        if (false === $UserGroupModel->AccessUserGroupBlock()->where($map)->delete()) {

            return $this->error('删除失败');
        }
        if (false === $UserGroupModel->save()) {
            
            return $this->error('删除失败');
        }

        return $this->success('删除成功', url('@admin/usergroup/')); 
    }

}