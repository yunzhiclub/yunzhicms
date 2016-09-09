<?php
namespace app\block\controller;

use app\model\BlockModel;                   // 区块模型

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

        $Object = new self();
        $Object->assign('BlockModel', $BlockModel);
        return $Object->fetch();
    }
}