<?php
namespace app\model;
/**
 * 用户组 - 区块 权限
 */
class AccessUserGroupBlockModel extends ModelModel
{
    protected $autoWriteTimestamp = false;

    /**
     * 检验当前登陆用户的相关权限
     * @param    integer                  $blockId 区块id
     * @param    string                   $action  action名
     * @return   bool                            
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-14T17:03:15+0800
     */
    static public function checkCurrentUserIsAllowedByBlockIdAndAction($blockId = 0, $action = '')
    {
        $userGroupName = UserModel::getCurrentUserModel()->getData('user_group_name');
        return self::checkIsAllowedByUserGroupNameAndBlockIdAndAction($userGroupName, $blockId, $action);
    }

    /**
     * 较验权限
     * @param    string                   $userGroupName 用户组名
     * @param    int                   $blockId       区块id
     * @param    string                   $action        action名
     * @return   bool                                  
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-14T17:03:49+0800
     */
    static public function checkIsAllowedByUserGroupNameAndBlockIdAndAction($userGroupName, $blockId, $action)
    {
        $map = [];
        $map['user_group_name'] = $userGroupName;
        $map['block_id'] = $blockId;
        $map['action']  = $action;
        if ('' === self::get($map)->getData('block_id')) {
            return false;
        } else {
            return true;
        }
    }
}
