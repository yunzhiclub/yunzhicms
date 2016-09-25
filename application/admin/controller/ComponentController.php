<?php
namespace app\admin\controller;
use app\Common;                         // 通用函数库
use app\model\ComponentModel;
class ComponentController extends AdminController
{
    public function indexAction()
    {
        $Components = ComponentModel::paginate();
        $this->assign('Components', $Components);
        return $this->fetch();
    }

    /**
     * 读取配置信息
     */
    public function readAction($name)
    {
        // 根据传入name获取信息
        $ComponentModel = ComponentModel::get($name);
        // var_dump($Component);
        $this->assign('ComponentModel', $ComponentModel);

        return $this->fetch();
    }

    public function createAction()
    {
        return $this->fetch('Component/create');
    }

    public function editAction($name)
    {
        $ComponentModel = ComponentModel::get($name);
        $this->assign('ComponentModel', $ComponentModel);
        return $this->fetch();
    }
}
