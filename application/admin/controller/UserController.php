<?php
namespace app\admin\controller;
use app\model\UserModel;            // 用户

/**
 * 实现用户管理的增删改查
 * @param  
 * @return template
 * @author liuyanzhao
 */

class UserController extends AdminController
{
    public function indexAction()
    {
        $userModels = new UserModel;
        $userModels = $userModels->where('is_deleted', '=', 0)->paginate();
        $this->assign('userModels', $userModels);

        return $this->fetch();
    }

    public function editAction($id)
    {
        $id = input('id');
        $UserModel = UserModel::get($id);
        $this->assign('UserModel', $UserModel);
        $UserGroup = $UserModel->getUsergroups();
        $this->assign('UserGroups', $UserGroup);
        return $this->fetch();
    }

    public function updateAction()
    {
        $data = input('param.');

        $UserModel        = UserModel::get($data['id']);
        $UserModel->setData('name', $data['name']);
        $UserModel->setData('email', $data['email']);
        $UserModel->setData('password', $data['password']);
        $UserModel->setData('qq_open_id', $data['qq_open_id']);
        $UserModel->setData('user_group_name', $data['user_group_name']);

        if (false !== $UserModel->save()) {  
            return $this->success('更新成功',url('@admin/user'));
        }
        return $this->success('更新成功', url('@admin/user'));
    }

    public function saveAction()
    {
        $data = input('param.');

        $UserModel = new UserModel;
        $UserModel->setData('name', $data['name']);
        $UserModel->setData('email', $data['email']);
        $UserModel->setData('password', $data['password']);
        $UserModel->setData('qq_open_id', $data['qq_open_id']);
        $UserModel->setData('user_group_name', $data['user_group_name']);

        $UserModel->save();
        return $this->success('操作成功', url('@admin/user/'));
    }

    public function createAction()
    {
        //取出用户组
        $User = new UserModel;
        $UserGroup = $User->getUsergroups();
        $this->assign('UserGroups', $UserGroup); 
        return $this->fetch();
    }

    public function deleteAction($id)
    {
        $UserModel = UserModel::get($id);
        $UserModel->setData('is_deleted', 1);
        if (false === $UserModel->save()) {
            return $this->error('删除失败');
        }
        return $this->success('删除成功', url('@admin/user/'));
    }
}