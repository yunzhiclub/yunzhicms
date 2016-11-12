<?php
namespace app\block\controller;

use app\model\UserModel;
/**
 * user
 */
class UserController extends BlockController
{
    public function index()
    {
        $UserModel = UserModel::getCurrentUserModel();
        $this->assign('UserModel', $UserModel);

        $token = $this->BlockModel->makeToken('edit');
        $this->assign('token', $token);
        // var_dump($token);
        return $this->fetch();
    }

    static public function edit()
    {
         // 实例化
        $Object = new self();
    }
}
