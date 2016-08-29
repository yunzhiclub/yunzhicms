<?php
namespace app\model;
/**
 * 用户
 */
class UserModel extends ModelModel
{
    protected $pk = 'id';

    private $UserGroupModel = null;         // 用户组
    

    public function getUserGroupModel()
    {
        if (null === $this->UserGroupModel)
        {
            $userGroupName = $this->getData('group_name');
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
}