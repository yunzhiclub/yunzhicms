<?php
namespace app\block\controller;

use think\Request;                          // 请求

use app\Common;                             // 通用模型
use app\model\BlockModel;                   // 区块模型
use app\model\FieldModel;                   // 字段模型

/**
 * 幻灯片
 */
class SliderController extends BlockController
{
    public function index()
    {
        // 生成token并送入V层，用于编辑该区块
        $token = $this->BlockModel->makeToken('Slider', 'edit');

        // 获取扩展字段列表, 并传入V层
        $this->assign('titles',         $this->BlockModel->FieldModel('titles')->filter());
        $this->assign('urls',           $this->BlockModel->FieldModel('urls')->filter());
        $this->assign('images',         $this->BlockModel->FieldModel('images')->filter());
        $this->assign('headers',        $this->BlockModel->FieldModel('headers')->filter());
        $this->assign('descriptions',   $this->BlockModel->FieldModel('descriptions')->filter());
        $this->assign('token', $token);
        return $this->fetch();
    }
    
    static public function save($data = [])
    {
        // 实例化
        $Object = new self();

        // 得到请求信息
        $Request = Request::instance();
        $param = $Request->param();
        
        // 判断传入的各个字段的个数是否相同，如果不同，报错提示各个字段个数必须相同!
        $fields = $param['field_'];
        $count = count(array_pop($fields));
        foreach ($fields as $value) {
            if ($count !== count($value)) {
                return $Object->error('各字段设置的参数个数不统一，请检查');
            }
        }
        
        // 更新扩展数据字段
        if (isset($param['field_'])) {
            FieldModel::updateLists($param['field_'], $data['id']);
        }

        $Object->success('操作成功', $Request->server('HTTP_REFERER'));
    }


    static public function edit($data = [])
    {
        // 检测KEY键是否传入
        if (!array_key_exists('id', $data)) {
            throw new \Exception("传入的参数有误", 1);
        }

        // 获取当前区块模型
        $BlockModel = BlockModel::get(['id' => $data['id']]);
        if ('' === $BlockModel->getData('id')) {
            throw new \Exception("未找到对应的区块模型", 1);
        }  

        // 实例化调用当前对象（如果是继承的本类，则实例那个继承本类的类）
        // 请学习new self()与new static()方法的区别
        $Object = new self();
        $Object->assign('BlockModel', $BlockModel);
        $Object->assign('token', Common::makeTokenByMCAData('block', 'Slider', 'save', ['id' => $BlockModel->getData('id')]));

        return $Object->fetch();
    }
}