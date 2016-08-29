<?php
namespace app\model;
/**
 * 用户组
 */
class UserGroupModel extends ModelModel
{
    protected $pk = 'name';
    public function getAccessValueByMenuModel(MenuModel &$MenuModel)
    {
        static $staticMenuModel = null;
        static $access = 0;
        if (null === $staticMenuModel || ($staticMenuModel->getData('id') !== $MenuModel->getData('id')))
        { 
            $map = [];
            $map['menu_id'] = $MenuModel->getData('id');
            $map['user_group_name'] = $this->getData('name');
            $AccessUserGroupMenuModel = AccessUserGroupMenuModel::get($map);
            if (null !== $AccessUserGroupMenuModel)
            {
                $access = (int)$AccessUserGroupMenuModel->getData('access');
            } else {
                $access = 0;
            }
            unset($AccessUserGroupMenuModel);
        }
        return $access;
    }

    /**
     * 是否当前菜单的的 读(0010) 权限
     * @param  MenuModel &$MenuModel 菜单
     * @return boolean               
     */
    public function isReadAllowedByMenuModel(MenuModel &$MenuModel)
    {
        return $this->getAccessByCURDValue($MenuModel, 2);
    }

    /**
     * 是否有当前菜单的 创建(1000) 权限
     * @param  MenuModel &$MenuModel [description]
     * @return boolean               [description]
     */
    public function isCreateAllowedByMenuModel(MenuModel &$MenuModel)
    {
        return $this->getAccessByCURDValue($MenuModel, 8);
    }

    /**
     * 是否拥有当前菜单的 更新（0100） 权限
     * @param  MenuModel &$MenuModel [description]
     * @return boolean               [description]
     */
    public function isUpdateAllowedByMenuModel(MenuModel &$MenuModel)
    {
        return $this->getAccessByCURDValue($MenuModel, 4);
    }

    /**
     * 是否拥有当前菜单的 删除(0001) 权限
     * @param  MenuModel &$MenuModel [description]
     * @return boolean               [description]
     */
    public function isDeleteAllowedByMenuModel(MenuModel &$MenuModel)
    {
        return $this->getAccessByCURDValue($MenuModel, 1);
    }

    /**
     * 通过传入的CURD具体值，判断当前用户组对菜单是否拥有权限
     * @param  int $CURDValue CURD(1111) 按拉对应
     * @return boolean            
     */
    public function getAccessByCURDValue(&$MenuModel, $CURDValue)
    {
        $access = $this->getAccessValueByMenuModel($MenuModel);
        if ($access & $CURDValue)
        {
            return true;
        } else {
            return false;
        }
    }
}