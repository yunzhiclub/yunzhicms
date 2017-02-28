<?php
namespace app\admin\controller;
use app\model\FieldModel;           //字段模型
use app\model\FieldTypeModel;       //字段类型模型
use think\Request;

class FieldController extends AdminController
{
    public function indexAction()
    {
        //获取传输过来的数据
        $request      = Request::instance();

        //获取当前操作的方法名
        $action       = $request->action();

        //获取查询的信息
        $relate_type  = $request->param('relate_type');
        $FieldModel   = new FieldModel;

        //取出按照relate_type与relate_value分类后的结果
        $FieldModels  = $FieldModel->getallrelatetypefield($relate_type);  

        //传值
        $this->assign('FieldModels', $FieldModels);
        $this->assign('action', $action);
        return $this->fetch('Field/index');
    }

    public function readAction()
    {
        //输入变量
        $request      = Request::instance();

        //获取当前的操作方法名
        $action       = $request->action();

        //获取查看的类型
        $relate_value = $request->param('relate_value');

        //查找数据
        $map          = array('relate_value' => $relate_value,
                            'is_delete'      => 0,
            );
        $FieldModel   = new FieldModel;
        $FieldModels  = $FieldModel->where($map)->order('weight', 'desc')->select();

        //取出一条数据,新增的时候传递relate_type与relate_value的值
        $FieldModel   = $FieldModel->where($map)->order('weight', 'desc')->find();

        //传值
        $this->assign('FieldModels', $FieldModels);
        $this->assign('FieldModel', $FieldModel);
        $this->assign('action', $action);

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

    /**
     * 新增
     * @param $action 用来判断新增后跳转第一个还是第二个界面 $realte_value $relate_type 第二个界面新增的参数
     * @return  template 
     * @author  gaoliming 
     */
    public function createAction($relate_value = null, $relate_type = null, $action = null)
    {
        $request         = Request::instance();
        $FieldModel      = new FieldModel;

        //取出所有的字段类型
        $FieldTypeModels = FieldTypeModel::all();

        //传值
        $this->assign('FieldTypeModels', $FieldTypeModels);
        $this->assign('relate_value', $relate_value);
        $this->assign('relate_type', $relate_type);
        $this->assign('FieldModel', $FieldModel);
        $this->assign('request', $request);

        //action是用来判断新增后跳转第一个还是第二个界面
        $this->assign('action', $action);
        
        return $this->fetch('Field/create');
    }

    /**
     * 保存
     * @return  template 
     * @author  gaoliming
     */
    public function saveAction()
    {
        $request    = Request::instance();
        $data       = $request->param();

        //获取aciton
        $action     = $data['action'];

        //获取参数，用来跳转到第二个界面的详细界面
        $param      = $data['param'];

        //保存数值
        $FieldModel = new FieldModel;
        $FieldModel->setData('title', $data['title']);
        $FieldModel->setData('name', $data['name']);
        $FieldModel->setData('relate_type', $data['relate_type']);
        $FieldModel->setData('relate_value', $data['relate_value']);
        $FieldModel->setData('field_type_name', $data['field_type_name']);
        $FieldModel->save();

        //跳转到第一个界面
        if ($action === 'index') {
            return $this->success('新增成功', url($action));
        }
        
        //跳转到第二个界面
        return $this->success('新增成功', url($action, ['relate_value' => $param]));
    }

    /**
     * 删除
     * @param id int 用来判断更新索引的键值
     * @return  template 
     * @author  gaoliming 
     */
    public function deleteAction($id)
    {
        //取出当前对象
        $FieldModel = FieldModel::get($id);

        //删除数据
        $FieldModel->setData('is_delete', 1)->save();

        $relate_value = $FieldModel->relate_value;
        return $this->success('删除成功', url('read', ['relate_value' => $relate_value]));
    }

    /**
     * 编辑
     * @return  template
     * @author  gaoliming
     */
    public function editAction($id)
    {
        //取出此对象
        $FieldModel = FieldModel::get($id);
        $this->assign('FieldModel', $FieldModel);

        //取出所有的字段类型
        $FieldTypeModels = FieldTypeModel::all();
        $this->assign('FieldTypeModels', $FieldTypeModels);

        return $this->fetch('Field/edit');
    }

    /**
     * 更新
     * @author  gaoliming
     */
    public function updateAction()
    {
        $request    = Request::instance();
        $data       = $request->param();

        //获取参数
        $param      = $data['param'];

        //取出变量
        $FieldModel = FieldModel::get($data['id']);
        $FieldModel->setData('title', $data['title']);
        $FieldModel->setData('relate_type', $data['relate_type']);
        $FieldModel->setData('relate_value', $data['relate_value']);
        $FieldModel->setData('field_type_name', $data['field_type_name']);

        //更新数据
        if (false === $FieldModel->isUpdate()->save()) {
            return $this->error('更新失败');
        }

        return $this->success('更新成功', url('read', ['relate_value' => $param]));
    }
}