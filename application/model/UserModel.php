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
            $userGroupName = $this->getData('user_group_name');
            $this->UserGroupModel = UserGroupModel::get($userGroupName);
        }
        return $this->UserGroupModel;
    }
}