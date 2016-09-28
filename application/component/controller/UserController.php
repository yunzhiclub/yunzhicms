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

    /**
     * 重置密码
     * @param  id $id
     * @return string
     * @author fanhaoling
     */
    public function resetAction($id)
    {
        $UserModel = UserModel::get($id);

        //密码重置
        $status = $UserModel->resetPassword($id);
        if ($status !== false) {
           return $this ->success('您的密码已重置，新密码为:' . config('resetPassword'),  Common::url('/index'));
        } else {
            return $this->error('重置密码失败');
        }
    }
}
