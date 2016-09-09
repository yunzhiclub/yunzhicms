<?php
namespace app\model;
use app\Common;
use think\File;
/**
 * text字段
 */
class FieldDataTextModel extends FieldModel 
{
    public function filter($value = null)
    {
        return $this->getData('value');
    }
}