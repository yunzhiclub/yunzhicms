<?php
namespace app\admin\controller;
use app\model\UserModel;
use think\Controller;
/**
 * 后台登陆
 * @author huangshuaibin
 */
class LoginController extends Controller
{
	public function indexAction()
	{		
		return $this->fetch();
	}

	public function loginAction()
	{
		//验证用户名 密码
		if (UserModel::login(input('post.username'), input('post.password'))) {			
			return $this->success('登陆成功', url('@admin/index'));
		} else{
			return $this->error('用户名或密码错误');
		}		
	}

	public function logoutAction()
	{
		//调用注销方法
		if (UserModel::logout()) {
			return $this->success('注销成功', url('index'));
		} else {
			return $this->error('注销失败', url('index'));
		}
	}
}