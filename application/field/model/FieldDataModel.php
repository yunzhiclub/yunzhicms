<?php
namespace app\field\model;
use app\YunzhiModel;
use app\model\FieldModel;
use app\label\controller\LabelController;

class FieldDataModel extends YunzhiModel
{
    private $FieldModel = null;

    public function FieldModel()
    {
        if (null === $this->FieldModel) {
            $this->FieldModel = FieldModel::get(['id' => $this->getData('field_id')]);
        }

        return $this->FieldModel;
    }

    /**
     * 渲染字段信息
     * @return   string                   渲染后的HTML代码
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-02T15:48:13+0800
     */
    public function render()
    {
        $LabelController = new LabelController;
        return $LabelController->renderFieldDataModel($this); 
    }
}