<?php
namespace app\model;
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

        foreach ($userGroups as $userGroupName => $userGroupStates)
        {
            
            if (!is_array($userGroupStates))
            {
                throw new Exception("传入的userGroups变量格式错误", 1);
            }

            $access = 0;
            foreach ($userGroupStates as $key => $userGroupStates)
            {
                // 按crud 来增加权限
                switch ($key) {
                    case 'delete':
                        $access = $access | 1;
                        break;

                    case 'read':
                        $access = $access | 2;
                        break;
                    
                    case 'update':
                        $access = $access | 4;
                        break;

                    case 'create':
                        $access = $access | 8;
                        break;

                    case 'index':
                        $access = $access | 16;
                        break;

                    default:
                        break;
                }
            }

            // 新增
            $data = new AccessUserGroupMenuModel;
            $data->setData('menu_id', (int)$menuId);
            $data->setData('user_group_name', $userGroupName);
            $data->setData('access', $access);
            $data->save();
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