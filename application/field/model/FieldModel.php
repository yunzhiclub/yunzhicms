<?php
namespace app\field\model;
use app\YunzhiModel;

class FieldModel extends YunzhiModel
{
    /**
     * 获取字段集
     * @param  string $type 实体类型
     * @param  int $key   实体 关键字
     * @param  1|0 $isOne      是否为1：1
     * @return list|lists             
     */
    public function getResult($type, $key, $isOne)
    {
        return '请重写getResult($type, $key, $isOne)';
    }
}