<?php
namespace app\model;

use think\Session;                      // session

/**
 * 用户
 */
class UserModel extends ModelModel
{
    static private $currentUserModel = null;  // 前台当前登陆用户
    private $UserGroupModel = null;           // 用户组

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
            $username = Session::get('username');
            // 判断是否是登录用户
            if (null === $username) {
                self::$currentUserModel = new UserModel;
                return self::$currentUserModel;
            }
            $map['username'] = $username;
            $currentUserModel = UserModel::get($map);
            return $currentUserModel;
        }

        return  self::$currentUserModel;
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
     * @param    string                   $username 用户邮箱    
     * @param    string                   $password 密码
     * @return   bool                             正确 true 错误 false
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-12T14:57:31+0800
     */
    static public function login($username, $password)
    {
        //将用户取出
        $map = array('username' => $username);
        $UserModel = UserModel::get($map);
        
        //判断用户是否存在
        if (!empty($UserModel->username)) {
            if ($UserModel->checkpassword($password)) {
                Session::set('username', $username);
                Session::set('loginTime', time());
                return true;
            }
        }        
        return false;    
    }
    /**
     * 验证登录用户是否为管理员，是则登录
     * @Author   litian,                  1181551049@qq.com
     * @DateTime 2016-09-23T17:38:20+0800
     * @param                             $username
     * @return                            boolean
     */
    static public function isAdmin($username)
    {
        //将用户取出
        $map = array('username' => $username);
        $UserModel = UserModel::get($map);
        
        // 判断用户是否为管理员
        if ('admin' === $UserModel->getData('user_group_name')) {
            return true;
        }
        return false;
    }
    /**
     * 验证密码
     * @param  string $password 密码
     * @return bool           密码正确  true 错误 false
     * @author huangshuaibin
     */
    public function checkpassword($password)
    {
        if($this->getData('password') === $password) {
            return true;
        } else {
            return false;
        }
        
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
        //索引
        $map = array(
            'is_admin'   => 0,
            'is_deleted' => 0,
            );
        $UserGroupModel = new UserGroupModel;
        return $UserGroupModel->where($map)->select();
    }

    /**
     * 重置密码
     * @param  int $id
     * @return   string
     * @author gaoliming   
     */
    public function resetPassword($id)
    {
        if ((int)$id === 0) {
            return false;
        } else {
            //取出密码并保存密码
            $this->password = config('resetPassword');
            $this->save();
        }
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

    /**
     * 设置默认的密码
     * @param 
     * @return string
     * @author liuyanzhao   
     */
    public function defaultPassword()
    {
        //初始密码请看config.php文件
        $password = config('defaultPassword');
        return $password;
    }
    
    /**
     * 关联用户组
     * @author  gaoliming 
     */
    public function get_Usergroup($user_group_name)
    {
        //索引
        $map = array('name' => $user_group_name);

        $UserGroup = new UserGroupModel;
        return $UserGroup->where($map)->find();
    }

    /**
     * 加密传进的密码
     * @param  string $password
     * @return string $encryptedpassword
     * @author liuyanzhao
     */
    public function encryptPassword($password)
    {
        $encryptedpassword = sha1(md5($password));
        return $encryptedpassword;
    }

    /**
     * 判断是否解冻
     * @param  int  $status 
     * @return int         
     * @author chuhang 
     */
    public function isFrozen($status)
    {
        if ($status === 0) {
            $result = 1;
            return $result;
        }
        $result = 0;
        return $result;
    }

}
