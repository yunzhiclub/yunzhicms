<?php
namespace app\filter\controller;
/**
 * 字段输入
 */
class FieldController extends FilterController
{
    public function renderFieldDataModel(&$FieldDataModel)
    {
        $this->assign('FieldDataModel', $FieldDataModel);

        $fieldType = $FieldDataModel->FieldModel()->FieldTypeModel()->getData('type');
        if (!empty($fieldType)) {
            return $this->fetch('filter@Field/' . $fieldType);
        } else {
            return '';
        }
    }
}