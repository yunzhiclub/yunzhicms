<?php
namespace app\model;
/**
 * 用户组 - 字段 权限
 */
class AccessUserGroupFieldModel extends ModelModel
{   
    /**
     * 判断当前用户是否可以访问该字段
     * @param    integer                  $fieldId 字段id
     * @return   bool                            
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-18T16:35:03+0800
     */
    static public function checkCurrentUserIsAllowedByFieldId($fieldId = 0) 
    {
        $userGroupName = UserModel::getCurrentUserModel()->getData('user_group_name');
        return self::checkIsAllowedByUserGroupNameAndFieldId($userGroupName, $fieldId);
    }

    /**
     * 判断是否可以访问该字段
     * @param    string                   $userGroupName 用户组名称
     * @param    int                   $fieldId       字段ID
     * @return   bool                                  能访问true, 不能访问false
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-18T16:35:31+0800
     */
    static public function checkIsAllowedByUserGroupNameAndFieldId($userGroupName, $fieldId)
    {
        $map = [];
        $map['user_group_name'] = $userGroupName;
        $map['field_id'] = $fieldId;
        if ('' === self::get($map)->getData('user_group_name')) {
            return false;
        } else {
            return true;
        }
    }
}