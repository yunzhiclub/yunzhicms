<?php
namespace app\admin\controller;

use app\model\UserModel;             // 用户模块
use app\model\UserGroupModel;        // 用户组模块
use think\Request;                   // 请求类

class PersonalController extends AdminController
{
	/**
	 * 显示用户信息
	 * 修改密码、姓名
     * @author litian
	 */
    public function indexAction()
    {
        $UserModel = new UserModel;

        //取出当前用户数据
    	$username = UserModel::getCurrentUser();
        $map['username'] = $username;
        $userModel = $UserModel::get($map);

        // 传入V层
        $this->assign('userModel', $userModel);

        return $this->fetch();
    }

    public function updateAction()
    {
     	$param = Request::instance()->param();

        //取出当前用户数据
        $username = UserModel::getCurrentUser();
        $UserModel = $UserModel::get($username);

     	// 验证原密码是否正确
		if (false === $UserModel->checkpassword()) {
            return $this -> error("原密码输入错误");
        }

		// 更新信息
		$UserModel->setData('password', $datas['password']);
		$UserModel->setData('name', $datas['name']);
        if(false === $UserModel->save()) {
        	return $this -> error("更改失败");
        }
        return $this ->success('个人信息更改成功');
    }

}
