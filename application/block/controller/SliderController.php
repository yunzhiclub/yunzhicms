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
    public function fetchHtml()
    {
        // 生成token并送入V层，用于编辑该区块
        $token = $this->BlockModel->makeToken('Slider', 'edit');

        $this->assign('token', $token);
        return $this->fetch();
    }
    
    static public function save($data = [])
    {
        $Request = Request::instance();
        $param = $Request->param();

        // 更新扩展数据字段
        if (isset($param['field_'])) {
            FieldModel::updateLists($param['field_'], $data['id']);
        }

        $Object = new self();
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