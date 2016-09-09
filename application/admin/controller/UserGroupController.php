<?php
namespace app\admin\controller;

use app\model\UserGroupModel;

class UserGroupController extends AdminController
{
    public function indexAction()
    {
    	$UserGroup = new UserGroupModel;
    	$this->assign('UserGroupModels', $UserGroup);
        return $this->fetch();
    }
}