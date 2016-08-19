<?php
namespace app\model;

class ContentModel extends YunzhiModel
{
    public function CategoryModel()
    {
        return $this->hasOne('CategoryModel', 'name', 'category_name');
    }
}