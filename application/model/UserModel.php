<?php
namespace app\model;

use think\Session;                      // session
/**
 * 用户
 */
class UserModel extends ModelModel
{
   
    static private $currentUserModel = null;  // 前台当前登陆用户
    private $UserGroupModel = null;         // 用户组

    protected $pk = 'id';
    protected $data = ['user_group_name' => 'public'];

    public function UserGroupModel()
    {
        if (null === $this->UserGroupModel)
        {
            $userGroupName = $this->getData('user_group_name');
            $this->UserGroupModel = UserGroupModel::get($userGroupName);
        }
        
        return $this->UserGroupModel;
    }

     /**
     * 获取当前用户
     * @return UserModel 
     */
    static public function getCurrentFrontUserModel()
    {
        if (null === self::$currentUserModel) {
            self::$currentUserModel = new UserModel;
        }

        return self::$currentUserModel;
    }

    static public function getCurrentUserModel()
    {
        return self::getCurrentFrontUserModel();
    }

    static public function logout()
    {
        // 销毁tokens
        Session::clear();
        return true;
    }

    /**
     * 用户登陆
     * @param    [type]                   $username [description]
     * @param    [type]                   $password [description]
     * @return   [type]                             [description]
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-12T14:57:31+0800
     */
    static public function login($username, $password)
    {
        Session::set('username', 'admin@mengyunzhi.com');
        return true;
    }


    /**
     * 用户是否登陆
     * @return   boolean                  
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-12T14:31:29+0800
     */
    static public function isLogin()
    {
        if (Session::get('username') !== null) {
            return true;
        } else {
            return false;
        }
    }

}