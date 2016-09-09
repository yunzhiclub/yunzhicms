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
        $userModels = UserModel::paginate();
        $this->assign('userModels', $userModels);

        return $this->fetch();
    }

    public function editAction($id)
    {
        $id = input('id');
        $UserModel = UserModel::get($id);
        $this->assign('UserModel', $UserModel);
        
        return $this->fetch();
    }

    public function updateAction()
    {
        $id = input('input.id');

        $UserModel        = UserModel::get($id);
        $UserModel->name  = input('post.name');
        $UserModel->password = input('post.password');
        $UserModel->email = input('post.email');
        

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
        dump($data['name']);

        $UserModel->save();
        return $this->success('操作成功', url('@admin/user/'));
    }

    public function createAction()
    {   
        $data = input('param.');

        $UserModel = new UserModel;
        $UserModel->setData('name', $data['name']);
        $UserModel->setData('email', $data['email']);
        $UserModel->setData('password', $data['password']);
        $UserModel->setData('qq_open_id', $data['qq_open_id']);
        $UserModel->setData('user_group_name', $data['user_group_name']);
       


        return $this->success('操作成功', url('@admin/user/'));
    }
}