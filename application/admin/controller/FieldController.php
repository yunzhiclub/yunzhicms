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

    /**
     * 更新权重
     * @return  
     * @author  gaoliming 
     */
    public function weightAction()
    {
        $data['status']  = 'ERROR';
        $data['message'] = '';

        //判断传过来的值是否为空
        $weight = $_POST['weight'];
        $weight = isset($weight) ? $weight : array();

        //执行更新
        $FieldModel = new FieldModel;
        $id         = $FieldModel->updateFieldWeight($weight);
        if (false === $id) {
            $data['message'][] = $id;
        }

        //更新成功,返回
        if ("" === $data['message']) {
            $data['status'] = 'SUCCESS';
            return $data;
        }

        //更新失败
        $data['message'] = '排序失败-' . implode(',', $data['message']);
        return $data;
    }
}