<?php
namespace app\model;
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
}