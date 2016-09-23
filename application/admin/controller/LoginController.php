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
		$username = input('post.username');
		$password = input('post.password');

		//验证用户名 密码
		if (UserModel::login($username, $password)) {
			// 验证登录用户是否为管理员
			if (UserModel::isAdmin($username)) {
				return $this->success('登陆成功', url('@admin/index'));
			}
			return $this->error('该用户无此权限');
		}
		return $this->error('用户名或密码错误');
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
