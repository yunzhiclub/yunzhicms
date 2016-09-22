<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use app\model\UserModel;
use think\Session; 

class AdminController extends Controller
{
    protected $currentUserModel = null;
    public function __construct()
    {
        parent::__construct();

        //添加session数据
        Session('username', 'admin@mengyunzhi.com');
        Session('loginTime', '1474536251');

        //获取用户登录信息
        $username = session('username');
        $loginTime = session('loginTime');

        if ($this->currentUserModel === null)
        {
        	$map['username'] = $username;
        	$this->currentUserModel = UserModel::get($map);
        }

        //判断用户是否有权限进入后台
        if ($this->currentUserModel->getAccessPermission() === false)
        {
        	return $this->error('请登录', url('Login/index'));
        }

        //判断用户是否登录、未操作时间
        if ($username = null || (time() - $loginTime > 30 * 60))
        {
        	return $this->error('请登录', url('Login/index'));
        } else {
        	session('username', $username);
        	session('loginTime', time());
        }

    }
}