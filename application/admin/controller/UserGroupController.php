<?php
namespace app\admin\controller;

use app\model\UserGroupModel;

class UserGroupController extends AdminController
{
    public function indexAction()
    {
    	$UserGroupModels = UserGroupModel::all();
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
        $UserGroupModel->delete();
        return $this->success('操作成功', url('@admin/usergroup/')); 
    }
}