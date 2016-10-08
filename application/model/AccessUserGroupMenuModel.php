<?php
namespace app\model;
use think\Exception;
/**
 * 用户组 - 菜单 权限
 */
class AccessUserGroupMenuModel extends ModelModel
{
    protected $autoWriteTimestamp = false;
    
    static public function checkCurrentUserCurrentMenuIsAllowedByAction($action)
    {
        $map = [];
        $map['user_group_name'] = UserModel::getCurrentUserModel()->getData('user_group_name');
        $map['menu_id']         = MenuModel::getCurrentMenuModel()->getData('id');
        $map['action']          = $action;
        if ('' === self::get($map)->getData('action')) {
            return false;
        } else {
            return true;
        }
    }
}