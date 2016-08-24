<?php
namespace app\field\model;
use app\YunzhiModel;

class FieldModel extends YunzhiModel
{
    /**
     * 获取字段集
     * @param  string $entityType 实体类型
     * @param  int $entityId   实体ID
     * @param  1|0 $isOne      是否为1：1
     * @return list|lists             
     */
    public function getResult($entityType, $entityId, $isOne)
    {
        return '请重写getResult($entityType, $entityId, $isOne)';
    }
}