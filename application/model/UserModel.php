<?php
namespace app\model;

use think\Session;                      // session
/**
 * 用户
 */
class UserModel extends ModelModel
{
    protected $pk = 'id';
    private   $UserGroupModel = null;         
    protected $type       = [
        // 设置create_time为时间戳类型（整型）
        'create_time' => 'datetime:Y/m/d',
    ];
    

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
        static $currentFrontUserModel = null;  // 前台当前登陆用户
        if (null === $currentFrontUserModel)
        {
            $currentUserModel = new UserModel;
            $currentUserModel->setData('group_name', 'public');
        }
        return $currentUserModel;
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

    /**
     * 增加时间戳的获取器
     * @param  $createtime
     * @return date
     * @author liuyanzhao
     */
    public function getCreateTimeAttr($createtime)
    {
        return date('Y/m/d',$createtime);
    }

    /**
     * 取UserGroup信息
     * @param  
     * @return object
     * @author liuyanzhao
     */
    public function userGroup()
    {
        return UserGroupModel::all();
    }

    /**
     * 验证数据库中是否存在输入的email
     * @param  string  $email  c层传来的数据
     * @return boolean  
     * @author liuyanzhao
     */
    public function isSameEmail($email)            
    {
        $map = array(
            'is_deleted' => 0,
            'username'  => $email
            );
        $UserModel = new UserModel;
        $User = $UserModel->where($map)->find();

        //判断数据表里面有没有相同的email
        if ('' === $User->getData('username')) {
            return false;
        } else {
            return true;
        }
    }

}