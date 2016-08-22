<?php
namespace app\model;

class CategoryModel extends YunzhiModel
{

    protected $pk = 'name';

    public function getName()
    {
        return $this->name;
    }
}