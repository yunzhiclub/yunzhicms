<?php
namespace app\model;
/**
 * 用户组
 */
class UserGroupModel extends ModelModel
{
    protected $pk = 'name';

    protected $data = ['name' => 'public'];
    /**
     * 获取 菜单 对本用户组的权限
     * @param  MenuModel &$MenuModel [description]
     * @return [type]                [description]
     */
    public function isAllowedByMenuModelAction(MenuModel &$MenuModel, $action)
    {
        // 查找是否存在当前权限值
        $map = [];
        $map['menu_id']         = $MenuModel->getData('id');
        $map['user_group_name'] = $this->getData('name');
        $map['action']          = $action;
       
        $AccessUserGroupMenuModel = AccessUserGroupMenuModel::get($map);
        if ('' !== $AccessUserGroupMenuModel->getData('menu_id'))
        {
            // 返回非默认值，有权限
            return true;
        } else {
            return false;
        }
    }

   
    /**
     * 获取当前用户组的所有用户
     * @param  string  $name 用户组name键值
     * @author  gaoliming
     */
    public function getAllUserModel($name)
    {
        //制定索引
        $map = array('user_group_name' => $name);

        //取出所有用户
        $UserModel = new UserModel;
        return $UserModel->where($map)->select();
    }

}