<?php
namespace app;
use think\Model;

class YunzhiModel extends Model
{
    public function __construct($data = [])
    {
        // 重写对应的数据表名
        if (empty($this->name)) {
            // 当前模型名
            $name = substr(get_class($this), 0, -strlen(config('model_suffix')));
            $this->name = basename(str_replace('\\', '/', $name));
        }

        parent::__construct($data);
    }

    public function setData($name, $value)
    {
        // 标记字段更改
        if (!isset($this->data[$name]) || ($this->data[$name] != $value && !in_array($name, $this->change))) {
            $this->change[] = $name;
        }
        // 设置数据对象属性
        $this->data[$name] = $value;
        return $this;
    }
}