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

    /**
     * 判断机读字段是不是纯英文
     * @param   string 
     * @author gaoliming
     * @return bool
     */
    static public function utf8_str($str)
    {
        $mb = mb_strlen($str, 'utf-8'); //返回uft-8下的字节长度
        $st = strlen($str);             //返回字符串长度
        if( $st === $mb) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 关键字查重
     * @param string $name 
     * @return  bool 
     * @author gaoliming 
     */
    static public function  isSameName($name)
    {
        //索引
        $map = array(
            'name'       => $name,
            'is_deleted' => 0
            );
        if ($name !== UserGroupModel::where($map)->find()->getData('name')) {
            return true;
        } else {
            return false;
        }
    }
}