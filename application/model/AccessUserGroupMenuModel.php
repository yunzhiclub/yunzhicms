<?php
namespace app\model;
use think\Exception;
/**
 * 用户组 - 菜单 权限
 */
class AccessUserGroupMenuModel extends ModelModel
{
    protected $autoWriteTimestamp = false;
    static public function updateByMenuIdAndUserGroups($menuId, $userGroups)
    {
        if (!is_array($userGroups))
        {
            throw new Exception("传入的userGroups变量格式错误", 1);
        }
        
        $map = [];
        $map['menu_id'] = (int)$menuId;

        // 删除全部记录
        self::destroy($map);


        // 修改实现权限管理的方法
        // author tangzhenjie
        foreach ($userGroups as $userGroupName => $userGroupStates)
        {
            
            if (!is_array($userGroupStates))
            {
                throw new Exception("传入的userGroups变量格式错误", 1);
            }
     
     
            // 新增
            // 存储具体权限
            foreach ($userGroupStates as $key => $userGroupState)
            {
                // 按crud 来增加权限
                switch ($key) {
                    case 'delete':
                        $data = new AccessUserGroupMenuModel;
                        $data->setData('menu_id', (int)$menuId);
                        $data->setData('user_group_name', $userGroupName);
                        $data->setData('action', 'delete');
                        $data->save();
                        break;

                    case 'read':
                        $data = new AccessUserGroupMenuModel;
                        $data->setData('menu_id', (int)$menuId);
                        $data->setData('user_group_name', $userGroupName);
                        $data->setData('action', 'read');
                        $data->save();
                        break;
                    
                    case 'update':
                        $data = new AccessUserGroupMenuModel;
                        $data->setData('menu_id', (int)$menuId);
                        $data->setData('user_group_name', $userGroupName);
                        $data->setData('action', 'update');
                        $data->save();
                        break;

                    case 'create':
                        $data = new AccessUserGroupMenuModel;
                        $data->setData('menu_id', (int)$menuId);
                        $data->setData('user_group_name', $userGroupName);
                        $data->setData('action', 'create');
                        $data->save();
                        break;

                    case 'index':
                        $data = new AccessUserGroupMenuModel; 
                        $data->setData('menu_id', (int)$menuId);
                        $data->setData('user_group_name', $userGroupName);
                        $data->setData('action', 'index');
                        $data->save();
                        break;

                    default:
                        break;
                }
            }
        }

        return true;
    }

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