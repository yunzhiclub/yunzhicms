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
        $id = Request::instance()->param('id');
        $UserModel = UserModel::get($id);

        //判断是否解冻
        $UserModel->setData('status', $UserModel->isFrozen($UserModel->getData('status')));

        $UserModel->save();
        return $this->success('修改成功');
    }

    public function resetAction()
    {
        return 'reset';
    }
}
