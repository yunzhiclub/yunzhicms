<?php
namespace app\field\model;
/**
 * body字段
 */
class FieldDataBodyModel extends FieldModel
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
        $map['is_deleted'] = '0';
        $map['entity_type'] = $entityType;
        $map['entity_id'] = $entityId;
        if ($isOne)
        {
            return $this->where($map)->find();
        } else {
            return $this->where($map)->order('weight desc')->select();
        }
    }
}

