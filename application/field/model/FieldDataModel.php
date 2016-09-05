<?php
namespace app\field\model;
use app\YunzhiModel;
use app\model\FieldModel;
use think\Loader;

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
     * 将驼峰式写法 改完 xx_x_型
     * @return   string                   
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-09-05T10:52:07+0800
     */
    public function getParseName()
    {
        return Loader::parseName($this->name);
    }
}