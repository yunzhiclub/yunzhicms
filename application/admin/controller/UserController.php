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
        $pagesize   = 5;
        $userModels = new UserModel;
        $userModels = $userModels->where('is_deleted', '=', 0)->paginate($pagesize);
        $this->assign('userModels', $userModels);

        //返回V层
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
        //根据id取数据
        $id = input('id');
        $UserModel = UserModel::get($id);

        //把取到的数据传进V层
        $this->assign('UserModel', $UserModel);

        //把用户管理界面的用户组取出来并传进V层
        $UserGroup = $UserModel->userGroup();
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

        //存进各项数据
        $UserModel        = UserModel::get($data['id']);
        $UserModel->setData('name', $data['name']);
        $UserModel->setData('username', $data['username']);
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
        $UserModel->setData('username', $data['username']);
        $UserModel->setData('user_group_name', $data['user_group_name']);
        $UserModel->save();
        return $this->success('操作成功', url('@admin/user/'));
    }

    public function createAction()
    {
        //取出用户组
        $User = new UserModel;
        $UserGroup = $User->userGroup();
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
        if (1 === $UserModel->is_admin) {
            return $this->error('此用户为超级管理员不能删除');
        }
        $UserModel->setData('is_deleted', 1)->save();
        return $this->success('删除成功', url('@admin/user/'));
    }

    /**
     * 重置密码
     * @param  id $id
     * @return string
     * @author  gaoliming  
     */
    public function resetPasswordAction($id)
    {
        $UserModel = UserModel::get($id);

        //将面重置
        $status = $UserModel->resetPassword($id);
        if ($status !== false) {
           return $this ->success('您的密码已重置，新密码为:' . config('resetPassword'), url('@admin/user'));
        } else {
            return $this->error('重置密码失败');
        }
    }

}