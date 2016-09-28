<?php
namespace app\component\controller;

use think\Request;                          // 请求

use app\Common;
use app\model\UserModel;                    // 用户

class UserController extends ComponentController
{
    public function indexAction()
    {
        $UserModel = UserModel::all();
        $this->assign('UserModel', $UserModel);
        // var_dump($UserModel);
        return $this->fetch();
    }

    public function editAction()
    {
        return 'edit';
    }

    public function frozenAction()
    {
        return 'frozen';
    }

    public function resetAction()
    {
        return 'reset';
    }
}
