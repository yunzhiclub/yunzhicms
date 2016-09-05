<?php
namespace app\field\model;
use app\YunzhiModel;
use app\model\FieldModel;

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
}