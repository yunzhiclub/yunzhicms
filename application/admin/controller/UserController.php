<?php
namespace app\admin\controller;

use app\model\UserModel;            // 用户管理

class UserController extends AdminController
{
    /**
     * 显示用户管理的界面
     * @param  
     * @return template
     * @author liuyanzhao
     */
    public function indexAction()
    {
        $Pagesize   = 5;
        $userModels = new UserModel;
        $userModels = $userModels->where('is_deleted', '=', 0)->paginate($Pagesize);
        $this->assign('userModels', $userModels);

        return $this->fetch();
    }

    /**
     * 跳转到用户的编辑界面
     * @param  
     * @return template
     * @author liuyanzhao
     */
    public function editAction($id)
    {
        $id = input('id');
        $UserModel = UserModel::get($id);
        $this->assign('UserModel', $UserModel);
        $UserGroup = $UserModel->getUsergroups();
        $this->assign('UserGroups', $UserGroup);
        return $this->fetch();
    }

    /**
     * 更新用户信息
     * @param  id
     * @return template
     * @author liuyanzhao
     */
    public function updateAction()
    {
        $data = input('param.');

        $UserModel        = UserModel::get($data['id']);
        $UserModel->setData('name', $data['name']);
        $UserModel->setData('email', $data['email']);
        $UserModel->setData('user_group_name', $data['user_group_name']);

        $UserModel->save(); 
        return $this->success('更新成功', url('@admin/user'));
    }

    /**
     * 存用户个人信息
     * @param  
     * @return boolean
     * @author liuyanzhao
     */
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

    /**
     * 删除用户
     * @param  [string] $id 
     * @return template
     * @author gaoliming
     */
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