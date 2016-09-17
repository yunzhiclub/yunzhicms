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
        //取分页配置信息
        $pageSize = config('paginate.var_page');
        $userModels = new UserModel;

        //设置条件
        $map = array(
            'is_deleted' => 0
            );

        //取出数据并传进V层
        $userModels = $userModels->where($map)->paginate($pageSize);
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

        //判断是不是超级管理员
        if (1 === $UserModel->get_Usergroup($UserModel->user_group_name)->is_admin) {
            return $this->error('此用户为超级管理员不能编辑');
        }

        
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
        $UserModel = UserModel::get($data['id']);
        
        //先判断邮箱或者用户名是否为空
        if ('' === $data['name'] || '' === $data['username']){
            return $this->error('姓名或者邮箱不能为空');
        }

        //再判断邮箱是否重复
        if ($UserModel->getData('username') !== $data['username']) {
            if ($UserModel->isSameEmail($data['username'])) {
                return $this->error('邮箱重复');
            }
        }

        //存进各项数据
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

        //判断是否存在相同的email
        if ($UserModel->isSameEmail($data['username'])) {
            return $this->error('邮箱重复');
        }

        //判断name是否为空
        if ('' === $data['name'] || '' === $data['username'])
        {
            return $this->error('姓名或者邮箱不能为空');
        }

        $UserModel->setData('name', $data['name']);
        $UserModel->setData('username', $data['username']);
        $UserModel->setData('user_group_name', $data['user_group_name']);
        $UserModel->setData('password', $UserModel->defaultPassword());

        $UserModel->save();
        return $this->success('操作成功', url('@admin/user/'));  
    }

    public function createAction()
    {
        //取出用户组,并传进V层
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
        if (1 === $UserModel->get_Usergroup($UserModel->user_group_name)->is_admin) {
            return $this->error('此用户为超级管理员不能删除');
        }
        $UserModel->setData('is_deleted', 1)->save();
        return $this->success('删除成功', url('@admin/user'));
    }
}