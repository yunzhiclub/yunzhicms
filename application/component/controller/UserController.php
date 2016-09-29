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
        $status = (int)$UserModel->getData('status');
        //判断是否解冻
        $UserModel->setData('status', $UserModel->isFrozen($status));

        $UserModel->save();
        if ($status ===1)
        {
            return $this->success('解冻成功');
        }
        return $this->success('冻结成功');
    }

    public function resetAction()
    {
        return 'reset';
    }
}
