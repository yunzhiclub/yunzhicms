<?php
namespace app\admin\controller;
use app\model\FieldModel;           //字段模型
use think\Request;

class FieldController extends AdminController
{
    public function indexAction()
    {
        //获取传输过来的数据
        $request      = Request::instance();
        $relate_type = $request->param('relate_type');
        $FieldModel   = new FieldModel;
        $FieldModels = $FieldModel->getallrelatetypefield($relate_type);  

        //传值
        $this->assign('FieldModels', $FieldModels);
        return $this->fetch('Field/index');
    }

    public function readAction()
    {
        //输入变量
        $request      = Request::instance();
        $relate_value = $request->param('relate_value');

        //查找数据
        $map          = array('relate_value' => $relate_value);
        $FieldModel   = new FieldModel;
        $FieldModels  = $FieldModel->where($map)->order('weight', 'desc')->select();
        $this->assign('FieldModels', $FieldModels);

        return $this->fetch('Field/read');
    }
}