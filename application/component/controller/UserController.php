<?php
namespace app\component\controller;

use think\Request;                          // 请求

use app\Common;
use app\model\UserModel;                    // 用户

class UserController extends ComponentController
{
    public function indexAction()
    {
        $UserModel = UserModel::all();
        $this->assign('UserModel', $UserModel);
        // var_dump($UserModel);
        return $this->fetch();
    }

   /**
     * 跳转到用户的编辑界面
     * @param  
     * @return template
     * @author fanhaoling
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
        return $this->fetch('component@User/edit');
    }
    /**
     * 更新用户信息
     * @param  id
     * @return template
     * @author fanhaoling
     */
    public function updateAction($id)
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

        return $this->success('更新成功', Common::url('/index'));
    }


    public function frozenAction()
    {
        return 'frozen';
    }

    /**
     * 重置密码
     * @param  id $id
     * @return string
     * @author fanhaoling
     */
    public function resetAction($id)
    {
        $UserModel = UserModel::get($id);

        //密码重置
        $status = $UserModel->resetPassword($id);
        if ($status !== false) {
           return $this ->success('您的密码已重置，新密码为:' . config('resetPassword'),  Common::url('/index'));
        } else {
            return $this->error('重置密码失败');
        }
    }
}
