<?php
namespace app\model;
/**
 * 用户组
 */
class UserGroupModel extends ModelModel
{
    protected $pk = 'name';

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
     * 是否当前菜单的的 列表(10000) 权限
     * @param  MenuModel &$MenuModel 菜单
     * @return boolean               
     */
    public function isIndexAllowedByMenuModel(MenuModel &$MenuModel)
    {
        return $this->isAllowedByMenuModelAction($MenuModel, 'index');
    }


    /**
     * 是否有当前菜单的 创建(01000) 权限
     * @param  MenuModel &$MenuModel [description]
     * @return boolean               [description]
     */
    public function isCreateAllowedByMenuModel(MenuModel &$MenuModel)
    {
        return $this->isAllowedByMenuModelAction($MenuModel, 'create');
    }

    /**
     * 是否拥有当前菜单的 更新（00100） 权限
     * @param  MenuModel &$MenuModel [description]
     * @return boolean               [description]
     */
    public function isUpdateAllowedByMenuModel(MenuModel &$MenuModel)
    {
        return $this->isAllowedByMenuModelAction($MenuModel, 'update');
    }

    /**
     * 是否当前菜单的的 读(00010) 权限
     * @param  MenuModel &$MenuModel 菜单
     * @return boolean               
     */
    public function isReadAllowedByMenuModel(MenuModel &$MenuModel)
    {
        return $this->isAllowedByMenuModelAction($MenuModel, 'read');
    }

    /**
     * 是否拥有当前菜单的 删除(00001) 权限
     * @param  MenuModel &$MenuModel [description]
     * @return boolean               [description]
     */
    public function isDeleteAllowedByMenuModel(MenuModel &$MenuModel)
    {
        return $this->isAllowedByMenuModelAction($MenuModel, 'delete');
    }

    /**
     * 取出用户组对应的所有用户
     * @return  array
     * @author gaoliming
     */
    public function getAllUserMedel($username)
    {
        $UserModel = new UserModel;
        $map = array('user_group_name' => $username);
        return $UserModel->where($map)->select();
    }
    

    /**
     * 返回关联对象
     * @return object
     * @author  gaoliming 
     */
    public function AccessUserGroupBlock()
    {
        $UserGroupBlock = new AccessUserGroupBlockModel;
        $this->data['AccessUserGroupBlock'] = $UserGroupBlock;
        return $UserGroupBlock;
    }
}