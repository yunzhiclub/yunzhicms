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
     * @author fanhaoling
	 */
    public function indexAction()
    {
    	$UserModel = new UserModel;
    	//取出数据并传进V层
    	$map = array(
    		'username' => 'admin@mengyunzhi.com'
    		);
        $userModels = $UserModel->where($map)->find();
        $this->assign('userModels', $userModels);

		// 传入用户组信息
		$UserGroups = UserGroupModel::all();
        $this->assign('UserGroups', $UserGroups);
        //返回V层
        return $this->fetch();
    }

    public function saveAction()
    {
     	$Request = Request::instance();
     	$datas = $Request->param();

        $UserModel = new UserModel;
    	//取当前用户信息
    	$map = array(
    		'username' => $datas['username']
    		);
        $userModel = $UserModel->where($map)->find();

     	// 验证原密码是否正确
		$password = $userModel->getData('password');
		$Password = $datas['password'];

		if ('' === $Password) {
			return $this->error('原密码不能为空', url('index'));
		}
		if ($password !== $Password) {
			return $this->error('原密码错误', url('index'));
		}

		// 验证新密码是否输入
		if ('' === $datas['newpassword']) {
		    $datas['password'] = $password;
        } else {
        	$datas['password'] = $datas['newpassword'];
        }

		// 验证两次密码是否输入一致
		if ($datas['newpassword'] !== $datas['repassword']) {
			return $this->error('两次密码输入不一致', url('index'));
		}

		// 更新信息
		$userModel->setData('password', $datas['password']);
		$userModel->setData('name', $datas['name']);
        if(false === $userModel->save()) {
        	return $this -> error("更改失败");
        }
        return $this ->success('个人信息更改成功');
    }

}