<?php
namespace app\component\controller;

use think\Request;                          // 请求

use app\Common;
use app\model\FieldModel;                   // 扩展字段类别
use app\model\UserModel;                    // 用户

class LoginController extends ComponentController
{
    public function indexAction()
    {
        // 判断登陆状态，如果已登陆，则显示注销信息。如果未登陆，则显示登陆信息
        if (UserModel::isLogin()) {
            return $this->logoutInfo();
        } else {
            return $this->loginInfo();
        }
    }

    /**
     * 注销
     * @return                      
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-12T14:52:04+0800
     */
    public function createAction()
    {
        // login or logout
    }

    /**
     * 登陆
     * @return                      
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-12T14:52:15+0800
     */
    public function checkAction()
    {
        $param = Request::instance()->param();

        // 查找用户名
        if (array_key_exists('username', $param)) {
            $username = $param['username'];
        } else {
            $this->error('传入数据有误');
        } 

        // 查找密码
        if (array_key_exists('password', $param)) {
            $password = $param['password'];
        } else {
            $this->error('传入数据有误');
        }

        // 登录
        if (UserModel::login($username, $password)) {
            $this->success('登录成功');
        } else 
        {
            $this->error('用户名或密码错误');
        }
    }

    public function loginInfo()
    {
        return $this->fetch('component@Login/loginInfo');   
    }

    public function logoutInfo()
    {
        return $this->fetch('component@Login/logoutInfo'); 
    }
}