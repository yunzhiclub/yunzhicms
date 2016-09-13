<?php
namespace app\model;
/**
 * 用户组
 */
class UserGroupModel extends ModelModel
{
    protected $pk = 'name';
    protected $accessOfAccessValueByMenuModel = 0;
    private $MenuModelOfAccessValueByMenuModel = null;

    /**
     * 获取 菜单 对本用户组的权限
     * @param  MenuModel &$MenuModel [description]
     * @return [type]                [description]
     */
    public function getAccessValueByMenuModel(MenuModel &$MenuModel)
    {
        // 使用成员变量，减小请求次数
        if (null === $this->MenuModelOfAccessValueByMenuModel || ($this->MenuModelOfAccessValueByMenuModel->getData('id') !== $MenuModel->getData('id')))
        { 
            $this->MenuModelOfAccessValueByMenuModel = $MenuModel;
            $map = [];
            $map['menu_id'] = $MenuModel->getData('id');
            $map['user_group_name'] = $this->getData('name');
            $AccessUserGroupMenuModel = AccessUserGroupMenuModel::get($map);
            if (null !== $AccessUserGroupMenuModel)
            {
                $this->accessOfAccessValueByMenuModel = (int)$AccessUserGroupMenuModel->getData('access');
            } else {
                $this->accessOfAccessValueByMenuModel = 0;
            }
            unset($AccessUserGroupMenuModel);
        }
        return $this->accessOfAccessValueByMenuModel;
    }

    /**
     * 是否当前菜单的的 列表(10000) 权限
     * @param  MenuModel &$MenuModel 菜单
     * @return boolean               
     */
    public function isIndexAllowedByMenuModel(MenuModel &$MenuModel)
    {
        return $this->getAccessByLCURDValue($MenuModel, 16);
    }


    /**
     * 是否有当前菜单的 创建(01000) 权限
     * @param  MenuModel &$MenuModel [description]
     * @return boolean               [description]
     */
    public function isCreateAllowedByMenuModel(MenuModel &$MenuModel)
    {
        return $this->getAccessByLCURDValue($MenuModel, 8);
    }

    /**
     * 是否拥有当前菜单的 更新（00100） 权限
     * @param  MenuModel &$MenuModel [description]
     * @return boolean               [description]
     */
    public function isUpdateAllowedByMenuModel(MenuModel &$MenuModel)
    {
        return $this->getAccessByLCURDValue($MenuModel, 4);
    }

    /**
     * 是否当前菜单的的 读(00010) 权限
     * @param  MenuModel &$MenuModel 菜单
     * @return boolean               
     */
    public function isReadAllowedByMenuModel(MenuModel &$MenuModel)
    {
        return $this->getAccessByLCURDValue($MenuModel, 2);
    }

    /**
     * 是否拥有当前菜单的 删除(00001) 权限
     * @param  MenuModel &$MenuModel [description]
     * @return boolean               [description]
     */
    public function isDeleteAllowedByMenuModel(MenuModel &$MenuModel)
    {
        return $this->getAccessByLCURDValue($MenuModel, 1);
    }

    /**
     * 通过传入的CURD具体值，判断当前用户组对菜单是否拥有权限
     * @param  int $CURDValue CURD(1111) 按拉对应
     * @return boolean            
     */
    public function getAccessByLCURDValue(&$MenuModel, $CURDValue)
    {
        $access = $this->getAccessValueByMenuModel($MenuModel);
        if ($access & $CURDValue)
        {
            return true;
        } else {
            return false;
        }
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