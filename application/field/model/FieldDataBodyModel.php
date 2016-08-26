<?php
namespace app\field\model;
/**
 * body字段
 */
class FieldDataBodyModel extends FieldModel
{
    /**
     * 获取字段集
     * @param  string $type 实体类型
     * @param  int $key   实体 KEY
     * @param  1|0 $isOne      是否为1：1
     * @return list|lists             
     */
    public function getResult($fieldConfigId, $key, $isOne)
    {
        $map['is_deleted'] = '0';
        $map['field_config_id'] = $fieldConfigId;
        $map['key'] = $key;
        if ($isOne)
        {
            return $this->where($map)->find();
        } else {
            return $this->where($map)->order('weight desc')->select();
        }
    }
}

