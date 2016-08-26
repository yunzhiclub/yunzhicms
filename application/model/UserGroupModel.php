<?php
namespace app\model;
/**
 * 用户组
 */
class UserGroupModel extends ModelModel
{
    protected $pk = 'name';
    public function isAllowedByMenuModel(MenuModel $MenuModel, $action = 'R')
    {

    }

    public function isReadAllowedByMenuModel(MenuModel &$MenuModel)
    {
        return true;
    }

    public function isCreateAllowedByMenuModel(MenuModel &$MenuModel)
    {
        return true;
    }

    public function isUpdateAllowedByMenuModel(MenuModel &$MenuModel)
    {
        return true;
    }

    public function isDeleteAllowedByMenuModel(MenuModel &$MenuModel)
    {
        return true;
    }
}