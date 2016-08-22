<?php
namespace app\field;
use think\Model;

class YunzhiField extends Model
{
    public function __construct($data = [])
    {
        // 重写对应的数据表名
        if (empty($this->name)) {
            // 当前模型名
            $name = substr(get_class($this), 0, -strlen('Field'));
            $this->name = basename(str_replace('\\', '/', $name));
        }

        parent::__construct($data);
    }

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