<?php
namespace app\admin\controller;
use app\model\UserModel;            // 用户

class UserController extends AdminController
{
    public function indexAction()
    {
        $userModels = UserModel::paginate();
        $this->assign('userModels', $userModels);

        return $this->fetch();
    }

    public function editAction($id)
    {
        $UserModel = UserModel::get($id);
        $this->assign('UserModel', $UserModel);
        
        return $this->fetch();
    }
}